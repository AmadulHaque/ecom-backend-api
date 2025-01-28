<?php

namespace App\Services;

use App\Enums\ItemStatus;
use App\Enums\ItemType;
use App\Enums\OrderStatus;
use App\Http\Resources\OrderReturnResource;
use App\Models\MerchantOrder;
use App\Models\OrderItem;
use App\Traits\Transaction;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerOrderService
{
    use Transaction;

    public static function getCustomerOrder($request)
    {
        $user = userInfo();
        $status = $request->status ?? null;
        $perPage = $request->input('per_page', 10);

        $orders = MerchantOrder::query()
            ->whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status_id', $status);
            })
            ->with([
                'merchant:id,name,shop_name',
                'orderItems:id,merchant_order_id,product_id,product_variation_id,price,quantity,status_id',
                'orderItems.product:id,name,slug',
                'orderItems.product_variant.variationAttributes.attributeOption:id,attribute_value',
                'orderItems.product_variant.variationAttributes.attribute:id,name',
            ])
            ->select('id', 'tracking_id', 'total_amount', 'shipping_amount', 'merchant_id', 'status_id')
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return formatPagination('Orders fetched successfully', $orders);
    }

    public static function getCustomerOrderDetails(string $tracking_id)
    {
        $user = userInfo();
        $merchantOrder = MerchantOrder::where('tracking_id', $tracking_id)
            ->whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with([
                'order:id,customer_name,customer_number,customer_landmark,customer_address,customer_location_id',
                'order.customer_location:id,name,type,parent_id',
                'order.customer_location.parent:id,name,type,parent_id',
                'order.customer_location.parent.parent:id,name,type,parent_id',
                'orderItems:id,merchant_order_id,product_id,product_variation_id,price,quantity,status_id',
                'orderItems.product:id,name,slug',
                'orderItems.product_variant:id,sku,product_id',
                'orderItems.product_variant.variationAttributes:id,attribute_option_id,product_variation_id,product_id,attribute_id',
                'orderItems.product_variant.variationAttributes.attributeOption:id,attribute_value',
                'orderItems.product_variant.variationAttributes.attribute:id,name',
            ])
            ->select('id', 'tracking_id', 'total_amount', 'shipping_amount', 'discount_amount', 'charge', 'sub_total', 'merchant_id', 'status_id', 'order_id', 'updated_at')
            ->first();

        $city = $merchantOrder->order->customer_location;
        $district = $city?->parent;
        $division = $district?->parent;

        return [
            'order' => $merchantOrder->id,
            'tracking_id' => $merchantOrder->tracking_id,
            'total_amount' => $merchantOrder->total_amount,
            'shipping_amount' => $merchantOrder->shipping_amount,
            'discount_amount' => $merchantOrder->discount_amount,
            'charge' => $merchantOrder->charge,
            'sub_total' => $merchantOrder->sub_total,
            'status_id' => $merchantOrder->status_id,
            'status' => $merchantOrder->status_label,
            'customer_name' => $merchantOrder->order->customer_name,
            'customer_number' => $merchantOrder->order->customer_number,
            'customer_landmark' => $merchantOrder->order->customer_landmark,
            'customer_address' => $merchantOrder->order->customer_address,
            'division' => $division?->name,
            'district' => $district?->name,
            'city' => $city?->name,
            'created_at' => $merchantOrder->created_at,
            'shop_id' => $merchantOrder->merchant->id,
            'shop_name' => $merchantOrder->merchant->shop_name,
            'shop_image' => $merchantOrder->merchant->image ?? '',
            'order_items' => $merchantOrder->orderItems->map(function ($item) use ($merchantOrder) {

                $thumbnail = $item->product->thumbnail;

                if (isset($item->product_variant) and $item->product_variant->image) {
                    $thumbnail = $item->product_variant->image;
                }

                $returnable = ($merchantOrder->status_id == OrderStatus::DELIVERED->value && Carbon::now()->diffInDays($merchantOrder->updated_at) > 3) ? false : true;

                return [
                    'id' => $item->id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'product_name' => $item->product->name,
                    'product_thumbnail' => $thumbnail ?? '',
                    'product_slug' => $item->product->slug,
                    'status' => $item->status_label,
                    'is_reviewed' => $item->review ? true : false,
                    'product_variant' => OrderService::getOrderItemVariantText($item->product_variant->variations ?? []),
                    'returnable' => $returnable,
                ];
            }),
        ];
    }

    public static function OrderItemCancel(array $data, string $tracking_id): mixed
    {
        DB::beginTransaction();

        try {
            $ids = $data['item_ids'];

            // Fetch the Merchant Order and validate it
            $merchantOrder = MerchantOrder::where('tracking_id', $tracking_id)->firstOrFail();

            // Fetch the relevant Order Items
            $orderItems = OrderItem::where('status_id', OrderStatus::PENDING->value)
                ->whereIn('id', $ids)
                ->get();

            if ($orderItems->isEmpty()) {
                throw new \Exception('No pending items found for cancellation.');
            }

            if ($orderItems->count() === 1) {
                $order = $orderItems->first()->merchant->order;

                $order->update([
                    'status_id' => OrderStatus::CANCELLED->value,
                ]);
            }

            // Update the status for the fetched items and create ItemCase entries
            $orderItems->each(function ($item) use ($data) {

                $item->update(['status_id' => OrderStatus::CANCELLED->value]);

                $item->itemCase()->create([
                    'reason_id' => $data['reason_id'],
                    'status' => ItemStatus::APPROVED->value,
                    'type' => ItemType::CANCELLED->value,
                ]);

                $merchantOrder = $item->merchant;

                $merchantOrder->update([
                    'sub_total' => $merchantOrder->sub_total - $item->price,
                    'total_amount' => $merchantOrder->total_amount - $item->price,
                ]);

                // Update the order total price and total amount
                $order = $item->merchant->order;

                \Log::info($order);

                $order->update([
                    'total_price' => $order->total_price - $item->price,
                    'total_amount' => $order->total_amount - $item->price,
                ]);
            });

            // Check if all items in the merchant order are now cancelled
            $remainingItemsCount = $merchantOrder->orderItems()
                ->where('status_id', '!=', OrderStatus::CANCELLED->value)
                ->count();

            if ($remainingItemsCount == 0) {
                $merchantOrder->update(['status_id' => OrderStatus::CANCELLED->value]);
            }

            DB::commit();

            return success('Items cancelled successfully.', 204);
        } catch (\Exception $e) {
            DB::rollBack();

            return failure($e->getMessage(), 500);
        }
    }

    public static function OrderItemReturn(array $data, string $tracking_id): JsonResponse
    {
        // if order created_at is greater than 3  days user can not return the product
        $order = MerchantOrder::where('tracking_id', $tracking_id)->first();
        $updated_at = $order->updated_at;

        if (Carbon::now()->diffInDays($updated_at) > 3) {
            return failure('You can not return the product after 3 days');
        }

        DB::beginTransaction();
        try {
            // Fetch the items first
            $orderItems = OrderItem::find($data['item_id']);
            if ($orderItems->status_id == OrderStatus::RETURNED->value) {
                return failure('Item already returned');
            }

            $orderItems->update([
                'status_id' => OrderStatus::RETURNED->value,
            ]);

            $item = $orderItems->itemCase()->create([
                'reason_id' => $data['reason_id'],
                'note' => $data['note'],
                'status' => ItemStatus::PENDING->value,
                'type' => ItemType::RETURNED->value,
            ]);
            if ($data['images']) {
                $item->images = $data['images'];
            }
            $item->save();
            DB::commit();

            return success('Item return request successfully', $item, 201);
        } catch (\Exception $e) {
            DB::rollback();

            return failure($e->getMessage(), 500);
        }
    }

    public static function getCustomerReturns(Request $request): JsonResponse
    {
        $status = OrderStatus::RETURNED->value;
        $orderItems = OrderItem::with([
            'merchant:id,order_id,tracking_id,total_amount,shipping_amount,charge,merchant_id,status_id',
            'merchant.order:id,user_id',
            'merchant.merchant:id,shop_name',
            'product:id,name,slug',
            'product_variant:id,sku',
            'product_variant.variationAttributes:id,attribute_option_id,product_variation_id,product_id,attribute_id',
            'product_variant.variationAttributes.attributeOption:id,attribute_value',
            'product_variant.variationAttributes.attribute:id,name',
            'itemCase:id,order_item_id,status',
        ])
            ->where('status_id', $status)
            ->whereHas('merchant', function ($query) {
                $query->whereHas('order', function ($q) {
                    $q->where('user_id', auth()->user()->id);
                });
            })->latest()->paginate();

        return resourceFormatPagination('Customer returns', OrderReturnResource::collection($orderItems->items()), $orderItems);
    }

    public static function getCustomerReturnDetails($id, $tracking_id): JsonResponse
    {
        $user = userInfo();
        $merchantOrder = MerchantOrder::where('tracking_id', $tracking_id)
            ->whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with([
                'order:id,customer_name,customer_number,customer_landmark,customer_address,customer_location_id',
                'order.customer_location:id,name,type,parent_id',
                'order.customer_location.parent:id,name,type,parent_id',
                'order.customer_location.parent.parent:id,name,type,parent_id',
                'orderItems:id,merchant_order_id,product_id,product_variation_id,price,quantity,status_id',
                'orderItems.product:id,name,slug',
                'orderItems.product_variant:id,sku,product_id',
                'orderItems.product_variant.variationAttributes:id,attribute_option_id,product_variation_id,product_id,attribute_id',
                'orderItems.product_variant.variationAttributes.attributeOption:id,attribute_value',
                'orderItems.product_variant.variationAttributes.attribute:id,name',
                'orderItems' => function ($query) {
                    $query->where('status_id', OrderStatus::RETURNED->value);
                },
            ])
            ->select('id', 'tracking_id', 'total_amount', 'shipping_amount', 'discount_amount', 'charge', 'sub_total', 'merchant_id', 'status_id', 'order_id')
            ->first();

        $city = $merchantOrder->order->customer_location;
        $district = $city?->parent;
        $division = $district?->parent;

        return success('Customer returns', [
            'order' => $merchantOrder->id,
            'tracking_id' => $merchantOrder->tracking_id,
            'total_amount' => $merchantOrder->total_amount,
            'shipping_amount' => $merchantOrder->shipping_amount,
            'discount_amount' => $merchantOrder->discount_amount,
            'charge' => $merchantOrder->charge,
            'sub_total' => $merchantOrder->sub_total,
            'status_id' => $merchantOrder->status_id,
            'status' => $merchantOrder->status_label,
            'customer_name' => $merchantOrder->order->customer_name,
            'customer_number' => $merchantOrder->order->customer_number,
            'customer_landmark' => $merchantOrder->order->customer_landmark,
            'customer_address' => $merchantOrder->order->customer_address,
            'division' => $division?->name,
            'district' => $district?->name,
            'city' => $city?->name,
            'created_at' => $merchantOrder->created_at,
            'shop_id' => $merchantOrder->merchant->id,
            'shop_name' => $merchantOrder->merchant->shop_name,
            'shop_image' => $merchantOrder->merchant->image ?? '',
            'order_items' => $merchantOrder->orderItems->map(function ($item) {
                $thumbnail = $item->product->thumbnail;
                if (isset($item->product_variant) and $item->product_variant->image) {
                    $thumbnail = $item->product_variant->image;
                }

                return [
                    'id' => $item->id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'product_name' => $item->product->name,
                    'product_thumbnail' => $thumbnail ?? '',
                    'product_slug' => $item->product->slug,
                    'status' => $item->status_label,
                    'is_reviewed' => $item->review ? true : false,
                    'product_variant' => OrderService::getOrderItemVariantText($item->product_variant->variations ?? []),
                ];
            }),

        ]);
    }
}

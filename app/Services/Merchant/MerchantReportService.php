<?php

namespace App\Services\Merchant;

use App\Models\Merchant;
use App\Models\ShopProduct;
use App\Models\MerchantReport;
use App\Models\ProductHoldStatus;
use App\Enums\ShopProductStatus;
use App\Enums\MerchantStatus;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MerchantReportService
{
    protected MerchantReport $merchantReport;
    
    public function __construct(MerchantReport $merchantReport)
    {
        $this->merchantReport = $merchantReport;
    }

    /**
     * Store merchant report and update related statuses
     *
     * @param array $data
     * @throws \Throwable
     * @return MerchantReport
     */
    public function store(array $data): MerchantReport
    {
        return DB::transaction(function () use ($data) {
            $data['added_by'] = Auth::id();
            
            $report = $this->merchantReport->create($data);
            
            $this->updateMerchantStatus($data['merchant_id']);
            $this->updateProductHoldStatuses($data['merchant_id']);
            $this->disableShopProducts($data['merchant_id']);
            
            return $report;
        });
    }

    /**
     * Find merchant report by ID
     *
     * @param int $id
     * @return MerchantReport|null
     */
    public function show(int $id): ?MerchantReport
    {
        return $this->merchantReport->findOrFail($id);
    }

    /**
     * Update merchant shop status
     *
     * @param int $merchantId
     * @return void
     */
    private function updateMerchantStatus(int $merchantId): void
    {
        Merchant::where('id', $merchantId)->update([
            'shop_status' => MerchantStatus::Suspended->value
        ]);
    }

    /**
     * Update or create product hold statuses
     *
     * @param int $merchantId
     * @return void
     */
    private function updateProductHoldStatuses(int $merchantId): void
    {
        ShopProduct::where('merchant_id', $merchantId)
            ->chunk(100, function ($products) use ($merchantId) {
                foreach ($products as $product) {
                    ProductHoldStatus::updateOrCreate(
                        [
                            'shop_product_id' => $product->id,
                            'merchant_id' => $merchantId
                        ],
                        ['status_id' => $product->status]
                    );
                }
            });
    }

    /**
     * Disable all shop products for merchant
     *
     * @param int $merchantId
     * @return void
     */
    private function disableShopProducts(int $merchantId): void
    {
        ShopProduct::where('merchant_id', $merchantId)
            ->update(['status' => ShopProductStatus::DISSABLED->value]);
    }
}

class MerchantService
{
    protected Merchant $merchant;

    public function __construct(Merchant $merchant)
    {
        $this->merchant = $merchant;
    }

    /**
     * Get paginated merchant list with search
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllMerchants(array $filters): LengthAwarePaginator
    {
        return $this->merchant->newQuery()
            ->when(
                $filters['search'] ?? null,
                fn (Builder $query, string $search) => $query->where(function ($q) use ($search) {
                    $q->whereAny(['phone', 'name', 'shop_name'], 'like', "%{$search}%");
                })
            )
            ->latest()
            ->paginate(
                $filters['per_page'] ?? 10,
                ['*'],
                'page',
                $filters['page'] ?? 1
            );
    }

    /**
     * Get merchants by search with limit
     *
     * @param array $filters
     * @return Collection
     */
    public function getMerchantsBySearch(array $filters): Collection
    {
        return $this->merchant->newQuery()
            ->when(
                $filters['search'] ?? null,
                fn (Builder $query, string $search) => $query->where(function ($q) use ($search) {
                    $q->whereAny(['phone', 'name', 'shop_name'], 'like', "%{$search}%");
                })
            )
            ->limit($filters['limit'] ?? 20)
            ->get();
    }

    /**
     * Find merchant by ID
     *
     * @param int $id
     * @return Merchant|null
     */
    public function findById(int $id): ?Merchant
    {
        return $this->merchant->findOrFail($id);
    }

    /**
     * Activate merchant and restore product statuses
     *
     * @param int $id
     * @return void
     */
    public function activateMerchant(int $id): void
    {
        DB::transaction(function () use ($id) {
            $merchant = $this->findById($id);
            
            $merchant->update(['shop_status' => MerchantStatus::Active->value]);
            
            $merchant->shop_products()
                ->with('productHoldStatus')
                ->chunk(100, function ($products) {
                    foreach ($products as $product) {
                        if ($product->productHoldStatus) {
                            $product->update([
                                'status' => $product->productHoldStatus->status_id
                            ]);
                        }
                    }
                });
        });
    }

    /**
     * Get merchant statistics
     *
     * @param int $id
     * @return array
     */
    public function getStatistics(int $id): array
    {
        $merchant = $this->findById($id);

        return [
            'products' => $merchant->products()->count(),
            'shop_products' => $merchant->shop_products()->count(),
            'orders' => $merchant->orders()->count(),
            'cancel_orders' => $merchant->orders()
                ->where('status_id', OrderStatus::CANCELLED->value)
                ->count(),
            'customers' => $merchant->customers()->count(),
        ];
    }
}
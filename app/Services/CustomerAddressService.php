<?php

namespace App\Services;

use App\Models\CustomerAddress;
use App\Traits\Transaction;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CustomerAddressService
{
    protected $model;

    public function __construct(CustomerAddress $model)
    {
        $this->model = $model;
    }

    public function getAll(): JsonResponse
    {
        try {
            // Fetch user addresses with related locations and their parent hierarchy
            $addresses = auth()->user()->addresses()
                ->with(['location.parent.parent']) // Eager load relationships
                ->select(
                    'id',
                    'name',
                    'landmark',
                    'address',
                    'address_type',
                    'contact_number',
                    'status',
                    'is_default_bill',
                    'is_default_ship',
                    'location_id'
                )
                ->get();

            // Fetch shipping settings once
            $settings = DB::table('shop_settings')
                ->whereIn('key', ['shipping_isd', 'shipping_fee_osd', 'shipping_fee_isd'])
                ->pluck('value', 'key');

            $isd = explode(',', $settings['shipping_isd']);
            $osdFee = intval($settings['shipping_fee_osd']);
            $isdFee = intval($settings['shipping_fee_isd']);

            // Map the addresses to include calculated fields
            $addressList = $addresses->map(function ($address) use ($isd, $osdFee, $isdFee) {
                $city = $address->location;
                $district = $city?->parent;
                $division = $district?->parent;

                $shipType = in_array($address->location_id, $isd) ? 'ISD' : 'OSD';
                $shipAmount = $shipType === 'ISD' ? $isdFee : $osdFee;

                return [
                    'id' => $address->id,
                    'name' => $address->name,
                    'landmark' => $address->landmark,
                    'address' => $address->address,
                    'address_type' => $address->address_type,
                    'contact_number' => $address->contact_number,
                    'status' => $address->status,
                    'is_default_bill' => $address->is_default_bill,
                    'is_default_ship' => $address->is_default_ship,
                    'city' => $city?->name,
                    'district' => $district?->name,
                    'division' => $division?->name,
                    'ship_type' => $shipType,
                    'ship_amount' => $shipAmount,
                ];
            });

            return success('Address list', $addressList);
        } catch (Exception $e) {
            return failure('Request failed: '.$e->getMessage(), 500);
        }

    }

    public function create(array $data = []): JsonResponse
    {
        try {
            Transaction::retryAndRollback(function () use ($data) {

                if (isset($data['is_default_bill']) && $data['is_default_bill'] == 1) {
                    auth()->user()->addresses()->update(['is_default_bill' => 0]);
                }

                if (isset($data['is_default_ship']) && $data['is_default_ship'] == 1) {
                    auth()->user()->addresses()->update(['is_default_ship' => 0]);
                }

                auth()->user()->addresses()->create($data);
            });

            return success('Address added successfully', [], 201);
        } catch (Exception $e) {
            return failure('Request failed: '.$e->getMessage(), 500);
        }
    }
}

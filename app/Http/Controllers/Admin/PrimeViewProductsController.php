<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrimeViewProductRequest;
use App\Services\PrimeViewProductService;
use App\Services\PrimeViewService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class PrimeViewProductsController extends Controller
{
    protected $primeViewProductService;

    protected $primeViewService;

    public function __construct(PrimeViewProductService $primeViewProductService, PrimeViewService $primeViewService)
    {
        $this->primeViewProductService = $primeViewProductService;
        $this->primeViewService = $primeViewService;
        $this->middleware('permission:prime-view-product-list')->only('index');
        $this->middleware('permission:prime-view-product-create')->only(['create', 'store']);
        $this->middleware('permission:prime-view-product-update')->only(['edit', 'update']);
        $this->middleware('permission:prime-view-product-delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $products = $this->primeViewProductService->getProducts($request);
        $prime_views = $this->primeViewService->getPrimeViewAll();
        if ($request->ajax()) {
            return view('components.prime-views.product_table', ['entity' => $products])->render();
        }

        return view('Admin::prime-views.products', compact('products','prime_views'));
    }

    public function create(Request $request)
    {
        $prime_views = $this->primeViewService->getPrimeViewAll();

        if ($request->ajax()) {
            $search = $request->search ?? '';
            $products = ProductService::getShopLimitProducts($search);

            return response()->json(['products' => $products]);
        }

        return view('Admin::prime-views.add-product', compact('prime_views'));
    }

    public function store(PrimeViewProductRequest $request)
    {
        $data = $request->validated();
        $this->primeViewProductService->storePrimeViewProduct($data);

        return response()->json([
            'message' => 'Products added successfully!',
        ]);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        $this->primeViewProductService->deletePrimeViewProduct($id);

        return response()->json(['message' => 'Product deleted Successfully']);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMerchantReportRequest;
use App\Services\Merchant\MerchantReportService;
use Illuminate\Http\Request;

class MerchantReportController extends Controller
{
    protected $merchantReportService;

    public function __construct(MerchantReportService $merchantReportService)
    {
        $this->merchantReportService = $merchantReportService;
    }



    public function store(CreateMerchantReportRequest $request)
    {
        try {
            $report = $this->merchantReportService->store($request->validated());
            return success('Merchant report created successfully');
        } catch (\Exception $e) {
            return failure($e->getMessage());
        }
    }


    public function  create(Request $request)
    {
        if (!$request->id) {
            abort(404);
        }    
        return view('Admin::merchant.report-create',['id' => $request->id]);

    }


    public function show($id)
    {
        $report = $this->merchantReportService->show($id);
        return view('Admin::merchant.report-show', compact('report'));
    }


}

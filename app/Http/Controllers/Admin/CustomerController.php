<?php

namespace App\Http\Controllers\Admin;

use App\Actions\CustomerList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:customer-list')->only('index');
        $this->middleware('permission:customer-show')->only('show');
    }

    public function index(Request $request)
    {
        $customers = (new CustomerList)->execute($request);
        if ($request->ajax()) {
            return view('components.customers.table', ['entity' => $customers])->render();
        }

        return view('Admin::customers.index', compact('customers'));
    }
}

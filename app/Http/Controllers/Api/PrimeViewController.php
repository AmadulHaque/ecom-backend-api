<?php

namespace App\Http\Controllers\Api;

use App\Actions\FetchPrimeViewProduct;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class PrimeViewController extends Controller
{
    public function primeView(Request $request)
    {
        try {
            $prime_views = FetchPrimeViewProduct::execute($request);

            return success('Prime View showed successfully', $prime_views);
        } catch (Exception $e) {
            return failure($e->getMessage(), 500);
        }
    }
}

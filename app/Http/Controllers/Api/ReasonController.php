<?php

namespace App\Http\Controllers\Api;

use App\Actions\FetchReason;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReasonController extends Controller
{
    public function reasons(Request $request)
    {
        $request['status'] = true;
        $data = (new FetchReason)->execute($request);

        return success('Reasons fetched successfully', $data);
    }
}

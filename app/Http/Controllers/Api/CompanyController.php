<?php

namespace App\Http\Controllers\Api;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index(){
        $companies = Company::all()->toArray();
        $response = [
            'success'=>true,
            'data'=>$companies,
            'message'=>'all companies'
        ];
        return response()->json($response, 200);
    }
}

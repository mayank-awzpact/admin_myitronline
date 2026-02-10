<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EcaRequestController extends Controller
{
    public function index()
{
    $ecarequest = DB::table('tbl_enquiry')
        ->select('uniqueId', 'name', 'email', 'phone_number', 'reference_url')
        ->orderBy('uniqueId', 'desc')
        ->get();

    return view('eca_request.eca_request', compact('ecarequest'));
}

}

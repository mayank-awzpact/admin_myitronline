<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentController extends Controller
{
    public function index()
{
    $rent = DB::table('tbl_rent_receipt')
        ->select(
            'name',
            'receiptId',
            'email',
            'phoneNumber',
            'tenant_pan',
            'houseAddress',
            'monthlyRent',
            'ownerName',
            'ownerPAN',
            'generateDate',
            'generateToDate',
            DB::raw('FROM_UNIXTIME(createdOn, "%Y-%m-%d %H:%i:%s") AS createdOn')
        )
        ->orderBy('createdOn', 'desc')
        ->get();

    return view('rent.rent_recipt', compact('rent'));
}

}

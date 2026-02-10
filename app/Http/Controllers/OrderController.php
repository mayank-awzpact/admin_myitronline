<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class OrderController extends Controller
{
    public function index()
    {
        $orders = DB::table('tbl_order')
            ->select(
                'orderId',
                'paymentGateway',
                DB::raw('CONCAT(COALESCE(fname, \'\'), \' \', COALESCE(lname, \'\')) AS name'),
                'email',
                'mobile',
                'amount',
                'cgstAmt',
                'sgstAmt',
                'tax_amount',
                'net_amount',
                'paymentGateway',
                'invoicePath',
                'tax_amount',
                DB::raw('COALESCE(paymentStatus, 0) AS paymentStatus'),
                DB::raw('COALESCE(orderFromName, "") AS orderFromName'),
                DB::raw('COALESCE(serviceUrl, "") AS serviceUrl'),
                DB::raw('FROM_UNIXTIME(createdOn, "%d-%m-%Y") AS createdOn')
            )
            ->whereNotIn('orderFromName', ['Consultancy Payment', 'Form16 Payment', 'Filing Multiple Form-16 Online'])
            ->orderBy('uniqueId', 'desc')
            ->get();
        return view('order.orders', compact('orders'));
    }

    public function old_oders()
    {
        $orders = DB::table('tbl_order_bkp_old AS o')
            ->leftJoin('tbl_payment_old_data AS p', 'o.orderId', '=', 'p.orderId')
            ->select(
                'o.orderId',
                'o.paymentGateway',
                DB::raw('CONCAT(COALESCE(o.fname, \'\'), \' \', COALESCE(o.lname, \'\')) AS name'),
                'o.email',
                'o.mobile',
                'o.amount',
                'o.cgstAmt',
                'o.sgstAmt',
                'o.tax_amount',
                'o.net_amount',
                'o.paymentGateway',
                'o.invoicePath',
                DB::raw('COALESCE(o.paymentStatus, 0) AS paymentStatus'),
                DB::raw('COALESCE(o.orderFromName, "") AS orderFromName'),
                DB::raw('COALESCE(o.serviceUrl, "") AS serviceUrl'),
                DB::raw('FROM_UNIXTIME(o.createdOn, "%d-%m-%Y") AS createdOn'),
                'p.bankTransactionId',
                'p.paymentOrderId',
                'p.transtionId',
                'p.gatewayName'
            )
            ->whereBetween('o.createdOn', [
                strtotime('2023-01-01 00:00:00'),
                strtotime('2024-12-31 23:59:59')
            ])
            ->orderByDesc('o.createdOn')
            ->get();
        return view('order.oldorders', compact('orders'));
    }


    public function consultancy()
    {
       $orders = DB::table('tbl_order')
        ->select(
        'orderId',
        'paymentGateway',
        DB::raw('CONCAT(COALESCE(fname, \'\'), \' \', COALESCE(lname, \'\')) AS name'),
        'email',
        'mobile',
        'amount',
        'cgstAmt',
        'sgstAmt',
        'tax_amount',
        'net_amount',
        'pan',
        DB::raw('COALESCE(paymentStatus, 0) AS paymentStatus'),
        DB::raw('COALESCE(orderFromName, "") AS orderFromName'),
        DB::raw('COALESCE(serviceUrl, "") AS serviceUrl'),
        DB::raw('FROM_UNIXTIME(createdOn, "%d-%m-%Y") AS createdOn')
    )
    ->where('orderFromName', 'Consultancy Payment')
    ->orderBy('uniqueId', 'desc')
    ->get();
        return view('order.consultancy', compact('orders'));
    }

        public function form16_payment()
        {
            $orders = DB::table('tbl_order')
                ->leftJoin('tbl_form16', 'tbl_form16.uniqueId', '=', 'tbl_order.form16_id')
                ->select(
                    'tbl_order.orderId',
                    'tbl_order.paymentGateway',
                    DB::raw('CONCAT(COALESCE(tbl_order.fname, \'\'), \' \', COALESCE(tbl_order.lname, \'\')) AS name'),
                    'tbl_order.email',
                    'tbl_order.mobile',
                    'tbl_order.amount',
                    'tbl_order.cgstAmt',
                    'tbl_order.sgstAmt',
                    'tbl_order.tax_amount',
                    'tbl_order.net_amount',
                    'tbl_order.form16_id',
                    DB::raw("REPLACE(tbl_order.invoicePath, 'public/', '') AS invoicePath"),
                    DB::raw('COALESCE(tbl_order.paymentStatus, 0) AS paymentStatus'),
                    DB::raw('COALESCE(tbl_order.orderFromName, "") AS orderFromName'),
                    DB::raw('COALESCE(tbl_order.serviceUrl, "") AS serviceUrl'),
                    DB::raw('FROM_UNIXTIME(tbl_order.createdOn, "%d-%m-%Y") AS createdOn'),
                    'tbl_form16.first_name',
                    'tbl_form16.email as form16_email',
                    'tbl_form16.phone',
                    'tbl_form16.gender',
                    'tbl_form16.full_address',
                    'tbl_form16.ifsc_code',
                    'tbl_form16.bank_name',
                    'tbl_form16.account_type',
                    'tbl_form16.pdfFilePath'
                )
                ->whereIn('tbl_order.orderFromName', ['Multiple Form-16 Submission', 'Form16 Payment', 'form16-itr1', 'form16-itr2'])
                ->orderByDesc('tbl_order.uniqueId')
                ->get();
            return view('order.form16_payment', compact('orders'));
        }

}

<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('getOrdersCount')) {
    function getOrdersCount()
    {
        return DB::table('tbl_order')->count();
    }
}

if (!function_exists('getEnquiryCount')) {
    function getEnquiryCount()
    {
        return DB::table('tbl_enquiry')->count();
    }
}

if (!function_exists('getRentCount')) {
    function getRentCount()
    {
        return DB::table('tbl_rent_receipt')->count();
    }
}

if (!function_exists('getServiceCount')) {
    function getServiceCount()
    {
        return DB::table('tbl_service_v2')->count();
    }
}

if (!function_exists('getConsultancyOrders')) {
    function getConsultancyOrders()
    {
        return DB::table('tbl_order')
            ->select(
                'orderId',
                'paymentGateway',
                DB::raw('CONCAT(COALESCE(fname, ""), " ", COALESCE(lname, "")) AS name'),
                'email',
                'mobile',
                'amount',
                'net_amount',
                DB::raw('COALESCE(paymentStatus, 0) AS paymentStatus'),
                DB::raw('COALESCE(orderFromName, "") AS orderFromName'),
                DB::raw('COALESCE(serviceUrl, "") AS serviceUrl'),
                DB::raw('FROM_UNIXTIME(createdOn, "%Y-%m-%d") AS createdOn')
            )
            ->where('orderFromName', 'Consultancy Payment')
            ->orderByDesc('uniqueId')
            ->limit(4)
            ->get();
    }
}

if (!function_exists('getConsultancyPaymentStatusCountsThisMonth')) {
    function getConsultancyPaymentStatusCountsThisMonth()
    {
        return DB::table('tbl_order')
            ->select(
                DB::raw("SUM(CASE WHEN paymentStatus = 1 THEN 1 ELSE 0 END) as paid"),
                DB::raw("SUM(CASE WHEN paymentStatus = 2 THEN 1 ELSE 0 END) as pending"),
                DB::raw("SUM(CASE WHEN paymentStatus = 0 THEN 1 ELSE 0 END) as failed"),
                DB::raw("SUM(CASE WHEN paymentStatus NOT IN (0,1,2) THEN 1 ELSE 0 END) as other")
            )
            ->where('orderFromName', 'Consultancy Payment')
            ->whereBetween(DB::raw('DATE(FROM_UNIXTIME(createdOn))'), [
                now()->startOfMonth()->toDateString(),
                now()->endOfMonth()->toDateString()
            ])
            ->first();
    }
}





if (!function_exists('getLatestOrders')) {
    function getLatestOrders()
    {
        return DB::table('tbl_order')
            ->select(
                'orderId',
                'paymentGateway',
                DB::raw('CONCAT(COALESCE(fname, \'\'), \' \', COALESCE(lname, \'\')) AS name'),
                'email',
                'mobile',
                'amount',
                DB::raw('COALESCE(paymentStatus, 0) AS paymentStatus'),
                DB::raw('COALESCE(orderFromName, "") AS orderFromName'),
                DB::raw('COALESCE(serviceUrl, "") AS serviceUrl'),
                DB::raw('FROM_UNIXTIME(createdOn, "%Y-%m-%d") AS createdOn')
            )
            ->whereNotIn('orderFromName', [
                'Consultancy Payment',
                'Form16 Payment',
                'Filing Multiple Form-16 Online'
            ])
            ->orderBy('uniqueId', 'desc')
            ->limit(4)
            ->get();
    }
}


if (!function_exists('getDailyMailStats')) {
    function getDailyMailStats()
    {
        return DB::table('bulk_mails')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw("COUNT(*) as count"))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->orderBy('month', 'asc')
            ->get();
    }
}

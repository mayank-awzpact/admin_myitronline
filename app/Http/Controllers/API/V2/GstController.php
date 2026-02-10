<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class GstController extends Controller
{
    public function gstSearch(Request $request)
    {
        // Validate the gst_number parameter
        $validator = Validator::make($request->all(), [
            'gst_number' => [
                'required',
                'string',
                'size:15',
                'regex:/^([0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1})$/'
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'gstDetails' => null,
                'error' => $validator->errors()
            ], 422); // 400 Bad Request
        }

        $gst_number = $request->query('gst_number');
        $gstDetails = null;
        $error = null;
        $status = 0;

        try {
            $response = Http::get("https://razorpay.com/api/gstin/{$gst_number}");
            Log::info("API Response: ", ['response' => $response->body()]);

            if ($response->successful()) {
                $gstDetails = $response->json();
                $status = 1;
            } else {
                $error = 'Invalid GST Number or API error..';
            }
        } catch (\Exception $e) {
            $error = 'An error occurred: ' . $e->getMessage();
            Log::error('Exception in ifscSearch: ', ['exception' => $e]);
        }

        return response()->json([
            'status' => $status,
            'gstDetails' => $gstDetails,
            'error' => $error
        ]);
    }
}

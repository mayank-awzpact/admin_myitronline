<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class BankController extends Controller
{

    public function ifscSearch(Request $request)
    {
        // Validate the ifsc_code parameter
        $validator = Validator::make($request->all(), [
            'ifsc_code' => 'required|string|max:11', // Assuming IFSC codes are alphanumeric and 11 characters long
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'bankDetails' => null,
                'error' => 'Invalid IFSC code format.'
            ], 400); // 400 Bad Request
        }

        $ifscCode = $request->query('ifsc_code');
        $bankDetails = null;
        $error = null;
        $status = 0;

        try {
            $response = Http::get("https://ifsc.razorpay.com/{$ifscCode}");
            Log::info("API Response: ", ['response' => $response->body()]);

            if ($response->successful()) {
                $bankDetails = $response->json();
                $status = 1;
            } else {
                $error = 'Invalid IFSC code or API error.';
            }
        } catch (\Exception $e) {
            $error = 'An error occurred: ' . $e->getMessage();
            Log::error('Exception in ifscSearch: ', ['exception' => $e]);
        }

        return response()->json([
            'status' => $status,
            'bankDetails' => $bankDetails,
            'error' => $error
        ]);
    }
}

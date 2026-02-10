<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PinCodeController extends Controller
{
    public function index(Request $request)
    {
        // Validate the pin_code parameter
        $validator = Validator::make($request->all(), [
            'pin_code' => [
                'required',
                'string',
                'size:6',
                'regex:/^[0-9]{6}$/'
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'data' => null,
                'error' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }

        $pin_code = $request->query('pin_code');
        $data = null;
        $error = null;
        $status = 0;

        try {
            $response = Http::get("https://api.postalpincode.in/pincode/{$pin_code}");
            Log::info("API Response: ", ['response' => $response->body()]);

            if ($response->successful()) {
                $responseData = $response->json();

                // Extract relevant fields from the first post office entry
                if (!empty($responseData[0]['PostOffice']) && is_array($responseData[0]['PostOffice'])) {
                    $postOffice = $responseData[0]['PostOffice'][0];
                    $data = [
                        'Circle' => $postOffice['Circle'] ?? null,
                        'District' => $postOffice['District'] ?? null,
                        'Division' => $postOffice['Division'] ?? null,
                        'Region' => $postOffice['Region'] ?? null,
                        'Block' => $postOffice['Block'] ?? 'NA',
                        'State' => $postOffice['State'] ?? null,
                        'Country' => $postOffice['Country'] ?? null,
                        'Pincode' => $postOffice['Pincode'] ?? null
                    ];
                    $status = 1;
                } else {
                    $error = 'No post office data found for the given pincode.';
                }
            } else {
                $error = 'Invalid Pincode Number or API error.';
            }
        } catch (\Exception $e) {
            $error = 'An error occurred: ' . $e->getMessage();
            Log::error('Exception in Pincode Number: ', ['exception' => $e]);
        }

        return response()->json([
            'status' => $status,
            'data' => $data,
            'error' => $error
        ]);
    }
}

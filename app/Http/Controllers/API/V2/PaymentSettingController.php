<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\V2\API\PaymentSetting;

class PaymentSettingController extends Controller
{
    /**
     * Get payment settings based on passed getawayName and key_mode.
     *
     * @param string $getawayName
     * @param int $key_mode
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPaymentSettings($getawayName, $key_mode)
    {
        // Validate the parameters
        $validatedData = [
            'getawayName' => $getawayName,
            'key_mode' => $key_mode,
        ];
    
        $validator = \Validator::make($validatedData, [
            'getawayName' => 'required|string',
            'key_mode' => 'required|integer|in:1,2',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'error' => $validator->errors()], 400);
        }
    
        // Fetch the settings from the database
        $settings = PaymentSetting::where('getawayName', $validatedData['getawayName'])
            ->where('key_mode', $validatedData['key_mode'])
            ->first(['key_id', 'key_secret']);

        if ($settings) {
            return response()->json(['status' => 200, 'data' => $settings], 200);
        } else {
            return response()->json(['status' => 404, 'error' => 'Settings not found'], 404);
        }
    }
    

}

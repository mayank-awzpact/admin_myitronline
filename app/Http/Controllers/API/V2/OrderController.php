<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\V2\API\Order;
use App\Models\V2\API\UserModal;

class OrderController extends Controller
{
    public function getOrderDetails($orderId)
    {
        // Validate the incoming request data
        $validator = Validator::make(['orderId' => $orderId], [
            'orderId' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid Order ID',
                'status' => 0,
            ], 400);
        }

        // Retrieve the order using the validated orderId
        $order = Order::where('orderId', $orderId)->first();

        // Check if the order was found
        if (!$order) {
            return response()->json([
                'message' => 'Order not found',
                'status' => 0,
            ], 404);
        }

        // Return the order details in the response
        return response()->json([
            'message' => 'Order retrieved successfully',
            'status' => 1,
            'data' => $order,
        ]);
    }

    public function updatePaymentStatus(Request $request, $orderId)
    {
        // Validate the paymentStatus field
        $validator = Validator::make($request->all(), [
            'paymentStatus' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid payment status',
                'status' => 0,
                'errors' => $validator->errors(),
            ], 400);
        }

        $order = Order::where('orderId', $orderId)->first();

        if (!$order) {
            return response()->json([
                'message' => 'Order not found',
                'status' => 0,
            ], 404);
        }

        $order->update([
            'paymentStatus' => $request->input('paymentStatus'),
        ]);

        return response()->json([
            'message' => 'Payment status updated successfully',
            'status' => 1,
            'data' => $order,
        ]);
    }

    public function getUserOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|min:1',
            'email' => 'required|email:rfc,dns',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'errors' => $validator->errors()], 400);
        }

        // Check if the user exists
        $user = UserModal::where('id', $request->id)->where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 404, 'message' => 'User not found'], 404);
        }

        // Retrieve the order using the validated user id
        $order = Order::where('userId', $user->id)
        ->select('orderId', 'serviceId', 'userId', 'serviceUrl','orderFrom','orderFromName', 'amount', 'cgstAmt', 'sgstAmt', 'tax_amount', 'net_amount', 'paymentStatus','createdOn')
        ->get();

        // Check if the order was found
        if (!$order) {
            return response()->json([
                'message' => 'Order not found',
                'status' => 0,
            ], 404);
        }

        // Return the order details in the response
        return response()->json([
            'message' => 'Order retrieved successfully',
            'status' => 1,
            'data' => $order,
        ]);
    }
}

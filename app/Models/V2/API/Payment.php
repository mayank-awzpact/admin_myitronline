<?php

namespace App\Models\V2\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\V2\API\Order;
use App\Models\V2\API\PaymentSetting;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'orderId',
        'paymentStatus',
        'gatewayName',
        'currency',
        'state',
        'responseCode',
        'bankTransactionId',
        'paymentOrderId',
        'transactionId',
        'transactionAmount',
        'transactionStatus',
        'paymentType',
        'paymentMsg',
        'transactionDate',
    ];

    protected $casts = [
        'transactionDate' => 'datetime',
    ];

    /**
     * Define relationships
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'orderId', 'orderId');
    }

    public function paymentSetting()
    {
        return $this->belongsTo(PaymentSetting::class, 'gatewayName', 'getawayName');
    }

    /**
     * Insert or update payment record
     *
     * @param string $orderId
     * @param array $data
     * @return bool
     */
    public static function insertOrUpdatePayment($orderId, $data)
    {
        return self::updateOrCreate(
            ['orderId' => $orderId],
            $data
        );
    }
}

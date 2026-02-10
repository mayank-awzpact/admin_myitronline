<?php

namespace App\Models\V2\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\V2\API\UserPan;
use App\Models\V2\API\UserAddress;
use App\Models\V2\API\Form16;
use App\Models\V2\API\Payment;


class Order extends Model
{
    use HasFactory;

    protected $table = 'tbl_order';

    protected $fillable = [
        'uniqueId',
        'fname',
        'name',
        'lname',
        'mobile',
        'email',
        'userGstNumber',
        'tax',
        'state',
        'companyAddress',
        'companyName',
        'pan',
        'pinCode',
        'orderId',
        'serviceId',
        'userId',
        'serviceUrl',
        'amount',
        'discount',
        'cgstAmt',
        'sgstAmt',
        'tax_amount',
        'net_amount',
        'paymentStatus',
        'appliedCoupon',
        'appliedCouponAmt',
        'couponCodeuniqueId',
        'invoiceNo',
        'paymentGateway',
        'email_send',
        'invoicePath',
        'orderFrom',
        'orderFromName',
        'form16_id',
        'browser',
        'browserVersion',
        'os',
        'device',
        'ip',
        'createdOn',
        'createdBy',
        'updatedOn',
        'updateBy',
        'isTrashed',
        'trashedOn',
        'verified_at', // Added the 'verified_at' column
    ];

    protected $casts = [
        'createdOn' => 'timestamp',
        'updatedOn' => 'timestamp',
        'trashedOn' => 'timestamp',
        'verified_at' => 'timestamp', // Cast 'verified_at' as timestamp
    ];


    public function userPan()
    {
        return $this->belongsTo(UserPan::class, 'pan_id', 'uniqueId');
    }

    public function userAddress()
    {
        return $this->belongsTo(UserAddress::class, 'address_id', 'addressId');
    }

    public function form16()
    {
        return $this->belongsTo(Form16::class, 'form16_id', 'uniqueId');
        
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'orderId', 'orderId');
    }
}

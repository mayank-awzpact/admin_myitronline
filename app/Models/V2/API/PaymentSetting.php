<?php

namespace App\Models\V2\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    use HasFactory;

    protected $table = 'tbl_payment_setting';
    protected $primaryKey = 'uniqueId';

    protected $fillable = [
        'getawayName',
        'className',
        'gatewayUrl',
        'statusUrl',
        'key_id',
        'key_secret',
        'key_mode',
        'active',
        'createdOn',
        'createdBy',
        'trashedOn',
        'isTrashed',
    ];

    public function payment()
    {
        return $this->hasMany(Payment::class, 'gatewayName', 'getawayName');
    }

    public static function activeSettings()
    {
        return self::where('active', 1)
                    ->where('isTrashed', 0)
                    ->get();
    }

}

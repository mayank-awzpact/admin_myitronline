<?php

namespace App\Models\V2\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $table = 'tbl_user_address';

    protected $fillable = [
        'addressId',
        'full_address',
        'address_manual_autometic',
        'houseBuildingApt',
        'streetRoadLane',
        'landmark',
        'areaLocalitySector',
        'villageTownCity',
        'district',
        'postOffice',
        'country',
        'state',
        'city',
        'pinCode',
        'refrence_id',
        'createdOn',
        'updatedOn',
        'updateBy',
        'isTrashed',
        'trashedOn',
        'verify_at',
    ];

    public $timestamps = false; // Assuming 'createdOn' and 'updatedOn' handle timestamps manually

}

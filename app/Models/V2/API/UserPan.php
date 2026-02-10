<?php

namespace App\Models\V2\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPan extends Model
{
    use HasFactory;

    protected $table = 'tbl_user_pan';

    protected $fillable = [
        'uniqueId',
        'pan',
        'aadhaar',
        'isPassport',
        'AssessmentYear',
        'refrence_id',
        'dob',
        'passportN',
        'createdOn',
        'updatedOn',
        'userId',
        'updateBy',
        'isTrashed',
        'trashedOn',
    ];

    // If you have timestamps or soft deletes, you can define them here
    // public $timestamps = true;
    // protected $dates = ['trashedOn'];
    // protected $softDelete = true;

    // Relationships or additional methods can be defined here
}

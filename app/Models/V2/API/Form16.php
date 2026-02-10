<?php

namespace App\Models\V2\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\V2\API\UserPan;
use App\Models\V2\API\UserAddress;

class Form16 extends Model
{
    use HasFactory;

    protected $table = 'tbl_form16';

    protected $fillable = [
        'uniqueId', 
        'first_name', 
        'last_name', 
        'email', 
        'phone', 
        'father_name', 
        'dob', // Keep 'dob' in fillable attributes
        'gender', 
        'pan_number', 
        'AssessmentYear', 
        'refrence_id', 
        'pan_id', 
        'address_id', 
        'full_address', 
        'account_number', 
        'ifsc_code', 
        'bank_name', 
        'account_type', 
        'pdfFilePath', 
        'pdfPassword', 
        'form16_source', 
        'source', 
        'createdOn', 
        'updatedOn', 
        'updateBy', 
        'isTrashed', 
        'trashedOn',
        'is_verified', // Added the 'is_verified' column
    ];

    protected $casts = [
        'dob' => 'string', // Cast 'dob' as string
        'createdOn' => 'timestamp', // Casting 'createdOn' as a timestamp
        'updatedOn' => 'timestamp', // Casting 'updatedOn' as a timestamp
        'trashedOn' => 'timestamp', // Casting 'trashedOn' as a timestamp
    ];

    // Define relationships
    public function userPan()
    {
        return $this->belongsTo(UserPan::class, 'pan_id', 'uniqueId');
    }

    public function userAddress()
    {
        return $this->belongsTo(UserAddress::class, 'address_id', 'addressId');
    }
}

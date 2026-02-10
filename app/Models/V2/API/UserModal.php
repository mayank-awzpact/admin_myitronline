<?php

namespace App\Models\V2\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;



class UserModal extends Authenticatable
{
    use Notifiable;

    protected $table = 'tbl_users_data';
    protected $primaryKey = 'id';
    public $timestamps = false;


    protected $fillable = [
       'id', 'userPic', 'pan', 'surName', 'affiliateId', 'mobile', 'email', 'birthdate', 'resisdentStatus', 'fName', 'lName', 'gender', 'Citizenship', 'aadhaar', 'areaLocality', 'isPassport', 'passportN', 'Pincode','state','city', 'password', 'isPasswordChange', 'PasswordChangeTime', 'createdOn', 'updatedOn', 'updateBy', 'isTrashed', 'active', 'trashedOn', 'isMobileVerified', 'mVerifiedOn', 'isEmailVerified', 'eVerifiedOn', 'browser', 'browserVersion', 'os', 'device', 'ip', 'domain_source', 'domain', 'login_at', 'logout_at'
    ];

    protected $hidden = [
        'password',
    ];

    protected $dates = [
        'createdOn',
        'updatedOn',
    ];

    // public function sendPasswordResetNotification($token)
    // {
    //     $this->notify(new ResetPasswordNotification($token));
    // }


}

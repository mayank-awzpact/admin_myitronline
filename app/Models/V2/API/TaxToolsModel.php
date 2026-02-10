<?php

namespace App\Models\V2\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TaxToolsModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_form12_bb'; // Specify the table if it doesn't follow naming conventions

    protected $fillable = [
        'receiptId',
        'fullName',
        'fathersName',
        'emailId',
        'mobileNo',
        'pan',
        'houseAddress',
        'place',
        'employeeID',
        'designationEmp',
        'nameOfOrganisation',
        'organisationEmailId',
        'itaAmount',
        'dedn_eighty_c',
        'dedn_other',
        'receiptPath',
        'pdfDownload',
        'browser',
        'browserVersion',
        'os',
        'device',
        'ip',
        'source',
        'domain',
        'createdOn',
    ];

    protected $casts = [
        'itaAmount' => 'json',
        'dedn_eighty_c' => 'json',
        'dedn_other' => 'json',
        'created_at' => 'datetime',
    ];

    public $timestamps = true;

    public function insertRentReceipt($data)
    {
        $save = [
            'receiptId' => 'RR-' . Carbon::now()->timestamp,
            'name' => $data['name_of_tenant'],
            'email' => $data['email'],
            'phoneNumber' => $data['mobile'],
            'tenant_pan' => $data['tenant_pan'],
            'monthlyRent' => $data['monthly_rent'],
            'houseAddress' => $data['full_address'],
            'ownerName' => $data['ownerName'],
            'ownerPAN' => $data['ownerPAN'],
            'generateDate' => $data['generateDate'],
            'generateToDate' => $data['generateToDate'],
            'browser' => $data['browser'],
            'browserVersion' => $data['browserVersion'],
            'os' => $data['os'],
            'device' => $data['device'],
            'ip' => $data['ip'],
            'source' => $data['source'],
            'domain' => $data['domain'],
            'createdOn' => Carbon::now()->timestamp,
        ];

        return DB::table('tbl_rent_receipt')->insertGetId($save);
    }

    public function insertForm12bb($data)
    {
        $save = [
            'receiptId' => 'RR-' . Carbon::now()->timestamp,
            'fullName' => $data['fullName'],
            'fathersName' => $data['fathersName'],
            'emailId' => $data['emailId'],
            'mobileNo' => $data['mobileNo'],
            'pan' => $data['pan'],
            'houseAddress' => $data['houseAddress'],
            'place' => $data['place'],
            'employeeID' => $data['employeeID'],
            'designationEmp' => $data['designationEmp'],
            'nameOfOrganisation' => $data['nameOfOrganisation'],
            'organisationEmailId' => $data['organisationEmailId'],

            'hraRentPaidToLandlord' => $data['hraRentPaidToLandlord'],
            'hraLandlordName' => $data['hraLandlordName'],
            'hraEvidence' => $data['hraEvidence'],
            'hraLandlordPan' => $data['hraLandlordPan'],
            'hraLandlordAddress' => $data['hraLandlordAddress'],

            'itaAmount' => $data['itaAmount'],
            'itaEvidence' => $data['itaEvidence'],

            'homeLoanInterestPayable' => $data['homeLoanInterestPayable'],
            'homeLoanLenderEvidence' => $data['homeLoanLenderEvidence'],
            'typeofLender' => $data['typeofLender'],
            'homeLoanLenderName' => $data['homeLoanLenderName'],
            'homeLoanLenderPan' => $data['homeLoanLenderPan'],
            'homeLoanLenderAddress' => $data['homeLoanLenderAddress'],

            'dednEightyC' => $data['dedn_eighty_c'],
            'dednEightyCAmount' => $data['dednEightyCAmount'],
            'dednEightyCEvidence' => $data['dednEightyCEvidence'],

            'dednOther' => $data['dedn_other'],
            'dednOtherAmount' => $data['dednOtherAmount'],
            'dednOtherEvidence' => $data['dednOtherEvidence'],

            'browser' => $data['browser'],
            'browserVersion' => $data['browserVersion'],
            'os' => $data['os'],
            'device' => $data['device'],
            'ip' => $data['ip'],
            'source' => $data['source'],
            'domain' => $data['domain'],
            'fy' => $data['fy'],
            'createdOn' =>  Carbon::now()->timestamp,
            'created_at' =>  now()->format('Y-m-d H:i:s'),
            
        ];
        return DB::table('tbl_form12_bb')->insertGetId($save);

    }

    public function getRentReceipt($id, $from)
    {
        return DB::table('tbl_rent_receipt')
            ->where($from, $id)
            ->get();
    }

    public function getForm12BBData($id)
    {
        return DB::table('tbl_form12_bb')
            ->where('uniqueId', $id)
            ->get();
    }
}

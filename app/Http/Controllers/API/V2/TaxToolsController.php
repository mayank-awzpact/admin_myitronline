<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\V2\API\TaxToolsModel;
use App\Jobs\SendRentReceiptMail;
use App\Jobs\SendForm12bbEmail;
use PDF;
use Illuminate\Support\Facades\File;

class TaxToolsController extends Controller
{
    protected $TaxToolsModel;
    protected $metaData;

    public function __construct(TaxToolsModel $TaxToolsModel)
    {
        $this->TaxToolsModel = $TaxToolsModel;

        $currentYear = date('Y');
        $currentMonth = date('n');

        $preYear = $currentYear - 2; // Adjusted to show FY year as one year prior
        $nextYear = $currentYear - 1; // Adjusted to show AY year as the current year

        // If the current month is after March, update the fiscal year data
        if ($currentMonth >= 3) {
            $preYear = $currentYear - 1;
            $nextYear = $currentYear; // Adjusted to show AY year as the next year
        }

        // Generate the fiscal year strings
        $fyString = "FY $preYear-" . substr($currentYear, 2); // Adjusted to show FY year as one year prior
        $ayString = "AY $currentYear-" . substr($nextYear + 1, 2);

        // Assign fiscal year strings to metaData array
        $this->metaData = [
            'fyString' => $fyString,
            'ayString' => $ayString,
        ];
    }


    
    
    public function createFrom12bb(Request $request)
    {
        $validatedData = $request->validate([
            'fullName' => 'required|string|max:225',
            'fathersName' => 'required|string|max:100',
            'emailId' => ['required', 'email:rfc,dns'],
            'mobileNo' => 'required|string|min:10|max:11',
            'pan' => 'required|string|max:100',
            'houseAddress' => 'required|string|max:255',
            'place' => 'required|string|max:100',

            'employeeID' => 'nullable|string|max:100',
            'designationEmp' => 'nullable|string|max:100',
            'nameOfOrganisation' => 'required|string|max:100',
            'organisationEmailId' => 'nullable|string|max:100',

            'hraRentPaidToLandlord' => 'nullable|string|max:100',
            'hraLandlordName' => 'nullable|string|max:100',
            'hraEvidence' => 'nullable|string|max:100',
            'hraLandlordPan' => 'nullable|string|max:100',
            'hraLandlordAddress' => 'nullable|string|max:255',

            'itaAmount' => 'nullable|array',
            'itaAmount.*' => 'nullable|string|max:255',
            'itaEvidence' => 'nullable|array',
            'itaEvidence.*' => 'nullable|string|max:255',

            'homeLoanInterestPayable' => 'nullable|string|max:100',
            'homeLoanLenderEvidence' => 'nullable|string|max:100',
            'typeofLender' => 'nullable|string|max:100',
            'homeLoanLenderName' => 'nullable|string|max:100',
            'homeLoanLenderPan' => 'nullable|string|max:100',
            'homeLoanLenderAddress' => 'nullable|string|max:255',

            'dedn_eighty_c' => 'nullable|array',
            'dedn_eighty_c.*' => 'nullable|string|max:255',
            'dednEightyCAmount' => 'nullable|array',
            'dednEightyCAmount.*' => 'nullable|string|max:255',
            'dednEightyCEvidence' => 'nullable|array',
            'dednEightyCEvidence.*' => 'nullable|string|max:255',

            'dedn_other' => 'nullable|array',
            'dedn_other.*' => 'nullable|string|max:255',
            'dednOtherAmount' => 'nullable|array',
            'dednOtherAmount.*' => 'nullable|string|max:255',
            'dednOtherEvidence' => 'nullable|array',
            'dednOtherEvidence.*' => 'nullable|string|max:255',

            'browser' => 'nullable|string|max:100',
            'browserVersion' => 'nullable|string|max:100',
            'os' => 'nullable|string|max:100',
            'device' => 'nullable|string|max:100',
            'ip' => 'nullable|string|max:100',
            'source' => 'required|string|max:100',
            'domain' => 'required|string|max:100',
        ]);

        // Handle array inputs
        $arrayFields = ['itaAmount', 'itaEvidence', 'dedn_eighty_c', 'dednEightyCAmount', 'dednEightyCEvidence', 'dedn_other', 'dednOtherAmount', 'dednOtherEvidence'];
        $jsonEncodedData = $this->prepareJsonArrayData($request, $arrayFields);

        // Merge the JSON encoded data with the validated data
        $dataToSave = array_merge($validatedData, $jsonEncodedData, [
            'fy' => $this->metaData['fyString'],
        ]);

         // Insert data into the database using the model
         $resp = $this->TaxToolsModel->insertForm12bb($dataToSave);  //print_r($resp); die;

         if ($resp) {
             $data = $this->prepareform12bbReceiptData($resp); 
             $pdf = $this->generatePdf('pdf.form12bb', ['data' => $data[0]]);
             $pdfPath = $this->storePdf($pdf, $resp, 'public/upload/form12bb/APK/');
 
             $storagePath = Storage::url($pdfPath);
 
             $this->updateForm12bb($resp, $storagePath);
         
             // Pass local path for email attachment
            $this->dispatchEmailJobForm12BB($validatedData['emailId'], $pdfPath);
         
            return $this->jsonResponse('Form12BB generated successfully', 1, [
                'receiptId' => $data[0]->receiptId,
                'created_at' => $data[0]->created_at,
            ]);

         } else {
             return $this->jsonResponse('Something went wrong', 0, 0);
         }

    }

    public function createRentReceipt(Request $request)
    {
        $validatedData = $request->validate([
            'name_of_tenant' => 'required|string',
            'email' => ['required', 'email:rfc,dns'],
            
            'mobile' => 'required|string|min:10|max:11',
            'tenant_pan' => 'nullable|string|max:100',

            'monthly_rent' => 'required|numeric|min:1001',
            'full_address' => 'required|string|max:255',

            'ownerName' => 'required|string|max:100',
            'ownerPAN' => 'nullable|string|max:100',

            'generateDate' => 'required|date',
            'generateToDate' => 'required|date',

            'browser' => 'nullable|string|max:100',
            'browserVersion' => 'nullable|string|max:100',
            'os' => 'nullable|string|max:100',
            'device' => 'nullable|string|max:100',
            'ip' => 'nullable|string|max:100',
            'source' => 'required|string|max:100',
            'domain' => 'required|string|max:100',
        ]);

        $resp = $this->TaxToolsModel->insertRentReceipt($validatedData);

        if ($resp) {
            $data = $this->prepareRentReceiptData($resp);
            $pdf = $this->generatePdf('rent-pdf', $data);

            // $rentPdfPath = $this->storePdf($pdf, $resp, 'public/uploads/rent-receipt/');
            // $receiptPath = Storage::url($rentPdfPath);

            
            $rentPdfPath = $this->storePdf($pdf, $resp, 'uploads/rent-receipt/');

// Get the URL to access the file
$receiptPath = asset($rentPdfPath); 
$this->updateRentReceipt($resp, $receiptPath);
            
            $this->dispatchEmailJob($validatedData['email'], $data, $receiptPath, $resp);

            return $this->jsonResponse('User Mail Sent successfully', 1, 'RR-' . $resp);
        } else {
            return $this->jsonResponse('Something went wrong', 0);
        }
    }

    protected function prepareJsonArrayData($request, $fields)
    {
        $result = [];
        foreach ($fields as $field) {
            if ($request->has($field) && $request->input($field) != "") {
                $result[$field] = json_encode($request->input($field));
            }
        }
        return $result;
    }

    protected function prepareRentReceiptData($resp)
    {
        $from = 'uniqueId';
        $res = $this->TaxToolsModel->getRentReceipt($resp, $from);
        $saveRentReceiptData = $res[0];
        return ['SaveRentReceiptData' => $saveRentReceiptData];
    }

    protected function prepareform12bbReceiptData($resp)
    {
        $from = 'uniqueId';
        return  $res = $this->TaxToolsModel->getForm12BBData($resp, $from);
    }

    protected function generatePdf($view, $data)
    {
        return PDF::loadView($view, $data);
    }

    protected function storePdf_bkp($pdf, $receiptId, $folder)
    {
        $receiptId = 'RR-' . $receiptId;
        $fileName = 'MYITR-' . $receiptId . '.pdf';
        $fullPath = $folder . $fileName;
        Storage::put($fullPath, $pdf->output());
        return $fullPath;
    }
protected function storePdf($pdf, $receiptId, $folder)
{
    // Ensure that the file is saved directly under the public folder
    $fileName = 'MYITR-' . $receiptId . '.pdf';
    $fullPath = public_path($folder . $fileName);  // Use public_path() to store in the public folder

    // Save the PDF to the public folder
    file_put_contents($fullPath, $pdf->output());

    // Return the full public URL of the file
    return $folder . $fileName; // Return relative path
}


    protected function updateRentReceipt($resp, $receiptPath)
    {
        $array = [
            'receiptId' => 'RR-' . $resp,
            'receiptPath' => $receiptPath
        ];
        DB::table('tbl_rent_receipt')
            ->where('uniqueId', $resp)
            ->update($array);
    }

    protected function updateForm12bb($resp, $storagePath)
    {
        $array = [
            'pdfDownload' => $storagePath,
            'receiptPath' => $storagePath
        ];
        DB::table('tbl_form12_bb')
            ->where('uniqueId', $resp)
            ->update($array);
    }

    protected function dispatchEmailJob($email, $data, $pdfPath, $resp)
    {
        $emailJob = new SendRentReceiptMail($email, $data, $pdfPath, $resp);
        $emailJob->delay(now()->addSeconds(5));
        dispatch($emailJob);
    }

    protected function dispatchEmailJobForm12BB($email, $receiptPath)
    {
        $emailJob = new SendForm12bbEmail($email, $receiptPath);
        $emailJob->delay(now()->addSeconds(5));
        dispatch($emailJob);
    }

    /**
     * Generate a JSON response.
     *
     * @param string $message
     * @param int $status
     * @param mixed $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function jsonResponse($message, $status = 1, $data = null)
    {
        return response()->json([
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ]);
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;


class Form16Controller extends Controller
{
    public function index()
    {
        $form16 = DB::table('form_16')
            ->select('id', 'form16json', 'created_at', 'pdf_path')
            ->orderBy('created_at', 'desc')
            ->get();
        foreach ($form16 as $item) {
            $item->form16json = json_decode($item->form16json, true);
        }
        // dd($form16);
        return view('form16.form16', compact('form16'));
    }


    public function direct_form16() {
        $form16 = DB::table('tbl_form16')
            ->select(
                // DB::raw("CONCAT(first_name, ' ', last_name) as full_name"),
                'first_name as full_name',
                'email',
                'phone',
                'full_address',
                'account_number',
                'ifsc_code',
                'bank_name',
                'pan_number',
                DB::raw("FROM_UNIXTIME(createdOn, '%d-%m-%Y %H:%i:%s') as created_date")
            )
            ->orderBy('uniqueId', 'desc')
            ->get();//print_r($form16);
//             foreach ($form16 as $requests) {
//     echo $this->safeDecrypt($requests->pan_number).'<br>';
// }
//     print_r($form16);die;
// $key = '123456789'; // Generates a random key
// $data = 'Sensitive data here';

// // Encrypt the data
// $encryptedData =  $this->sodiumEncrypt($data, $key);
// echo "Encrypted Data: " . $encryptedData . "\n";

// // Decrypt the data
// $decryptedData = $this->sodiumDecrypt($encryptedData, $key);
// echo "Decrypted Data: " . $decryptedData . "\n";
// echo $encrypted = 'eyJpdiI6IjNNQXlRaitXaUhmU1VsQVdQN0wzUmc9PSIsInZhbHVlIjoiYjJNUnZRWmZnVTNnRE9ZTjRuSlN1SXREUENKaFVYcjZ0bmFSZnhTa09WST0iLCJtYWMiOiI1MjExNmM5NTI5MTY3NDI3ODI0MWNlYTk0NmQ5MGRmODU3NTJhOWU0Zjg4MGViYjMyM2FlNDFiNGVjMDE5YmRhIiwidGFnIjoiIn0=';

// // Decrypt data later
// echo $decrypted = Crypt::decrypt($encrypted);
        return view('form16.direct_form16', compact('form16'));
    }

 function sodiumEncrypt($data, $key)
    {
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES); // Generate random nonce
        $encryptedData = sodium_crypto_secretbox($data, $nonce, $key); // Encrypt data with nonce and key
        return base64_encode($nonce . $encryptedData); // Return encrypted data with nonce in base64 format
    }
     function sodiumDecrypt($data, $key)
    {
        $decodedData = base64_decode($data); // Decode from base64
        $nonce = substr($decodedData, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES); // Extract nonce
        $ciphertext = substr($decodedData, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES); // Extract ciphertext
        return sodium_crypto_secretbox_open($ciphertext, $nonce, $key); // Decrypt
    }

}

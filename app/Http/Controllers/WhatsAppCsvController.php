<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsAppCsvController extends Controller
{
    public function showForm()
    {
        return view('whatsapp.upload');
    }

    public function sendFromCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $rows = array_map('str_getcsv', file($file));
        $header = array_map('strtolower', $rows[0]);
        unset($rows[0]); // remove header row

        $success = 0;
        $failed = 0;

        $token = env('WHATSAPP_TOKEN');
        $phoneNumberId = env('WHATSAPP_PHONE_NUMBER_ID');
        $templateName = env('WHATSAPP_TEMPLATE_NAME');
        $language = env('WHATSAPP_TEMPLATE_LANGUAGE');

        foreach ($rows as $row) {
            $data = array_combine($header, $row);

            $phone = trim($data['phone'] ?? '');
            $name  = trim($data['name'] ?? '');

            if (!$phone || !$name) {
                $failed++;
                continue;
            }

            $response = Http::withToken($token)->post("https://graph.facebook.com/v19.0/{$phoneNumberId}/messages", [
                'messaging_product' => 'whatsapp',
                'to' => $phone,
                'type' => 'template',
                'template' => [
                    'name' => $templateName,
                    'language' => ['code' => $language],
                    'components' => [
                        [
                            'type' => 'body',
                            'parameters' => [
                                ['type' => 'text', 'text' => $name]
                            ]
                        ]
                    ]
                ]
            ]);

            $response->successful() ? $success++ : $failed++;
        }

        return back()->with([
            'success' => "{$success} message(s) sent successfully.",
            'error' => $failed > 0 ? "{$failed} message(s) failed." : null,
        ]);
    }
}

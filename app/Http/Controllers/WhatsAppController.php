<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsAppController extends Controller
{
    public function showForm()
    {
        return view('whatsapp.upload');
    }

    // public function sendMessages(Request $request)
    // {
    //     $request->validate([
    //         'csv_file' => 'required|file|mimes:csv,txt',
    //         'message' => 'required|string',
    //     ]);

    //     $instanceId = 'instance130038';
    //     $token = '7pbnui9fv7daalgu';
    //     $message = $request->input('message');

    //     $file = $request->file('csv_file');
    //     $rows = array_map('str_getcsv', file($file));
    //     unset($rows[0]);

    //     $successCount = 0;
    //     $failCount = 0;

    //     foreach ($rows as $row) {
    //         if (empty($row[0])) continue;

    //         $phone = trim($row[0]);
    //         if (!str_starts_with($phone, '+')) {
    //             $phone = '+91' . $phone;
    //         }

    //         $response = Http::asForm()->post("https://api.ultramsg.com/{$instanceId}/messages/chat", [
    //             'token' => $token,
    //             'to'    => $phone,
    //             'body'  => $message,
    //         ]);

    //         if ($response->successful()) {
    //             $successCount++;
    //         } else {
    //             $failCount++;
    //         }
    //     }

    //     return back()->with('success', "$successCount message(s) sent,  $failCount failed.");
    // }

//     public function sendMessages(Request $request)
// {
//     $request->validate([
//         'csv_file' => 'required|file|mimes:csv,txt',
//         'message' => 'required|string',
//     ]);

//     $instanceId = 'instance130038';
//     $token = '7pbnui9fv7daalgu';
//     $message = $request->input('message');

//     $file = $request->file('csv_file');
//     $content = file_get_contents($file);
//     $lines = explode(PHP_EOL, $content);

//     $successCount = 0;
//     $failCount = 0;

//     if (count($lines) > 1 && str_contains(strtolower($lines[0]), 'phone')) {
//         array_shift($lines);
//     }

//     foreach ($lines as $line) {
//         if (empty(trim($line))) continue;

//         $row = str_getcsv($line);
//         if (!isset($row[0]) || empty($row[0])) continue;

//         $phone = trim($row[0]);

//         if (!str_starts_with($phone, '+')) {
//             $phone = '+91' . $phone;
//         }

//         $response = Http::asForm()->post("https://api.ultramsg.com/{$instanceId}/messages/chat", [
//             'token' => $token,
//             'to'    => $phone,
//             'body'  => $message,
//         ]);

//         if ($response->successful()) {
//             $successCount++;
//         } else {
//             $failCount++;
//         }
//     }

//     return back()->with('success', "{$successCount} message(s) sent, {$failCount} failed.");
// }


// public function sendMessages(Request $request)
// {
//     $request->validate([
//         'csv_file' => 'required|file|mimes:csv,txt',
//         'message' => 'required|string',
//         'image_url' => 'required|url',
//     ]);

//     $instanceId = 'instance130038';
//     $token = '7pbnui9fv7daalgu';
//     $message = $request->input('message');
//     $imageUrl = $request->input('image_url');

//     $file = $request->file('csv_file');
//     $rows = array_map('str_getcsv', file($file));
//     unset($rows[0]);

//     $successCount = 0;
//     $failCount = 0;

//     foreach ($rows as $row) {
//         if (empty($row[0])) continue;

//         $phone = trim($row[0]);
//         if (!str_starts_with($phone, '+')) {
//             $phone = '+91' . $phone;
//         }

//         $response = Http::asForm()->post("https://api.ultramsg.com/{$instanceId}/messages/image", [
//             'token'   => $token,
//             'to'      => $phone,
//             'image'   => $imageUrl,
//             'caption' => $message,
//         ]);

//         if ($response->successful()) {
//             $successCount++;
//         } else {
//             $failCount++;
//         }
//     }

//     return back()->with('success', "$successCount message(s) sent, $failCount failed.");
// }






// public function sendMessages(Request $request)
// {
//     $request->validate([
//         'csv_file' => 'required|file|mimes:csv,txt',
//         'message' => 'required|string',
//     ]);

//     $instanceId = 'instance130038';
//     $token = '7pbnui9fv7daalgu';

//     $rawMessage = $request->input('message');

//     $message = strip_tags($rawMessage, '<br>');
//     $message = str_replace(['<br>', '<br/>', '<br />'], "\n", $message);
//     $message = html_entity_decode($message);


//     $file = $request->file('csv_file');
//     $rows = array_map('str_getcsv', file($file));
//     unset($rows[0]);

//     $successCount = 0;
//     $failCount = 0;

//     foreach ($rows as $row) {
//         if (empty($row[0])) continue;

//         $phone = trim($row[0]);

//         // Add country code if not already present
//         if (!str_starts_with($phone, '+')) {
//             $phone = '+91' . $phone;
//         }

//         try {
//             $response = Http::timeout(20)->asForm()->post("https://api.ultramsg.com/{$instanceId}/messages/chat", [
//                 'token' => $token,
//                 'to'    => $phone,
//                 'body'  => $message,
//             ]);

//             if ($response->successful()) {
//                 $successCount++;
//             } else {
//                 Log::warning("Failed to send message to {$phone}. Response: " . $response->body());
//                 $failCount++;
//             }
//         } catch (\Exception $e) {
//             Log::error("WhatsApp message error: " . $e->getMessage());
//             $failCount++;
//         }
//     }

//     return back()->with('success', "$successCount message(s) sent, $failCount failed.");
// }


public function sendMessages(Request $request)
{
    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt',
        'message' => 'required|string',
    ]);

    $instanceId = 'instance130038';
    $token = '7pbnui9fv7daalgu';

    $rawMessage = $request->input('message');

    $message = strip_tags($rawMessage, '<br>');

    $message = str_replace(['<br>', '<br/>', '<br />'], "\n", $message);

    $message = html_entity_decode($message);

    $file = $request->file('csv_file');
    $rows = array_map('str_getcsv', file($file));
    unset($rows[0]);

    $successCount = 0;
    $failCount = 0;

    foreach ($rows as $row) {
        if (empty($row[0])) continue;

        $phone = trim($row[0]);

        if (!str_starts_with($phone, '+')) {
            $phone = '+91' . $phone;
        }

        try {
            $response = Http::timeout(20)->asForm()->post("https://api.ultramsg.com/{$instanceId}/messages/chat", [
                'token' => $token,
                'to'    => $phone,
                'body'  => $message,
            ]);

            if ($response->successful()) {
                $successCount++;
            } else {
                Log::warning("Failed to send message to {$phone}. Response: " . $response->body());
                $failCount++;
            }
        } catch (\Exception $e) {
            Log::error("WhatsApp message error: " . $e->getMessage());
            $failCount++;
        }
    }

    return back()->with('success', "$successCount message(s) sent, $failCount failed.");
}



}

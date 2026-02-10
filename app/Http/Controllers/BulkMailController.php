<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Mail\BulkMail;
use Illuminate\Support\Facades\Mail;

class BulkMailController extends Controller
{
    // public function index(Request $request)
    // {
    //     $search = $request->input('search');

    //     $query = DB::table('bulk_mails');

    //     if ($search) {
    //         $query->where(function ($q) use ($search) {
    //             $q->where('user_mail', 'like', "%$search%")
    //               ->orWhere('subject', 'like', "%$search%");
    //         });
    //     }

    //     $mails = $query->orderByDesc('id')->paginate(10);

    //     return view('bulkmail.index', compact('mails', 'search'));
    // }

    public function index(Request $request)
{
    $search = $request->input('search');
    $date = $request->input('date');

    $query = DB::table('bulk_mails');

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('user_mail', 'like', "%$search%")
              ->orWhere('subject', 'like', "%$search%");
        });
    }

    if ($date) {
        $query->whereDate('date', $date);
    } elseif (!$search && !$date) {
        $query->whereDate('date', now()->toDateString());
    }

    $mails = $query->orderByDesc('id')->get(); // No pagination

    return view('bulkmail.index', compact('mails', 'search', 'date'));
}


    public function create()
    {
        return view('bulkmail.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sender_mail'  => 'required|email',
            'date'         => 'required|date',
            'subject'      => 'required|string|max:255',
            'description'  => 'required|string',
            'img_url'      => 'required|string',
            'mail_heading' => 'required|string',
            'user_mail.*'  => 'nullable|email',
            'email_csv'    => 'nullable|file|mimes:csv,txt|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $emails = [];

        if ($request->has('user_mail')) {
            $emails = array_merge($emails, array_filter($request->user_mail));
        }

        if ($request->hasFile('email_csv')) {
            $file = fopen($request->file('email_csv')->getRealPath(), 'r');
            while (($line = fgetcsv($file)) !== false) {
                foreach ($line as $column) {
                    $clean = trim($column);
                    if (filter_var($clean, FILTER_VALIDATE_EMAIL)) {
                        $emails[] = $clean;
                    }
                }
            }
            fclose($file);
        }

        $emails = array_unique($emails);

        if (empty($emails)) {
            return back()->with('error', 'No valid email addresses found.');
        }

        foreach ($emails as $email) {
            DB::table('bulk_mails')->insert([
                'sender_mail'  => $request->sender_mail,
                'user_mail'    => $email,
                'date'         => $request->date,
                'subject'      => $request->subject,
                'description'  => $request->description,
                'img_url'      => $request->img_url,
                'mail_heading' => $request->mail_heading,
            ]);
        }

        return redirect()->route('bulkmail.index')->with('success', 'Bulk mail entries created successfully.');
    }

    public function edit($id)
    {
        $mail = DB::table('bulk_mails')->where('id', Crypt::decryptString($id))->first();
        // dd($mail);
        return view('bulkmail.edit', compact('mail'));
    }

        public function update(Request $request, $id)
        {
            $request->validate([
                'sender_mail'  => 'required|email',
                'user_mail'    => 'required|email',
                'date'         => 'required|date',
                'subject'      => 'required|string|max:255',
                'description'  => 'required|string',
                'img_url'      => 'required|string',
                'mail_heading' => 'required|string',
            ]);

            DB::table('bulk_mails')->where('id', Crypt::decryptString($id))
                ->update([
                    'sender_mail'  => $request->sender_mail,
                    'user_mail'    => $request->user_mail,
                    'date'         => $request->date,
                    'subject'      => $request->subject,
                    'description'  => $request->description,
                    'img_url'      => $request->img_url,
                    'mail_heading' => $request->mail_heading,
                ]);

            return redirect()->route('bulkmail.index')->with('success', 'Bulk mail entry updated successfully.');
        }


    public function destroy($id)
    {
        DB::table('bulk_mails')->where('id', $id)->delete();
        return redirect()->route('bulkmail.index')->with('success', 'Bulk mail entry deleted successfully.');
    }

    public function bulk_mail_send(Request $request)
    {
        $id = $request->input('mail_id');
        $mail = DB::table('bulk_mails')->where('id', $id)->first();

        if (!$mail) {
            return back()->with('error', 'Mail not found.');
        }

        $details = [
            'subject' => $mail->subject,
            'body' => $mail->description,
            'img' => $mail->img_url,
            'heading' => $mail->mail_heading,
        ];

        Mail::to($mail->user_mail)->send(new BulkMail($details));

        return back()->with('success', 'Mail sent!');
    }

    public function sendBulk(Request $request)
    {
        $ids = $request->input('selected_ids');


          if (is_string($ids)) {
        $ids = explode(',', $ids);
    }

    if (!$ids || !is_array($ids)) {
        return back()->with('error', 'No emails selected.');
    }


        $mails = DB::table('bulk_mails')->whereIn('id', $ids)->get();
// print_r($mails);die;
        foreach ($mails as $mail) {
            $details = [
                'subject' => $mail->subject,
                'body' => $mail->description,
                'img' => $mail->img_url,
                'heading' => $mail->mail_heading,
            ];

            try {
                Mail::to($mail->user_mail)->send(new BulkMail($details));
            } catch (\Exception $e) {
                \Log::error("Failed to send mail to {$mail->user_mail}: " . $e->getMessage());
            }
        }

        return back()->with('success', 'Selected mails have been sent.');
    }
}

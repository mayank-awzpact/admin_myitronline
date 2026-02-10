<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Route;
use Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;

class MyitrQuizController extends Controller
{  public function __construct()
    {
    
}
     public function quizresult_list()
    {
       
        $quizAnswers = DB::table('quiz_answer')->orderBy('id', 'DESC')->get();
      
        // dd($quizAnswers);
        return view('myitr_quiz.quiz_list', compact('quizAnswers'));
    }
    function add_quiz_result(){
       
        // $today = Carbon::today()->toDateString();
        $matches = DB::table('ipl_matches_2025')
    ->whereDate('match_date2', '>', '2025-04-01') // Sirf 01-04-2025 ke baad wale matches
    ->orderBy('match_date2', 'ASC')
    ->get();



            return view('myitr_quiz.quiz_result_add', compact('matches'));
    }
//     function submit_quiz_result(Request $request){
//           // Validate the form inputs
//     $validated = $request->validate([
//         'match_name' => 'required|string',
//         'q1' => 'required|string',
//         'q2' => 'required|string',
//         'q3' => 'required|string',
//         'q4' => 'required|string',
//         'q5' => 'required|string',
//     ]);

//     try {
//        $data =  DB::table('quiz_answer')->insert([
//             'match_name' => $request->match_name,
//             'q1' => $request->q1,
//             'q2' => $request->q2,
//             'q3' => $request->q3,
//             'q4' => $request->q4,
//             'q5' => $request->q5,
//             'created_at' => now(),
//             'updated_at' => now(),
//         ]);
      

//         return redirect()->route('/quiz-result-list')->with('success', 'Quiz submitted successfully!');
//     } catch (\Exception $e) {

//         Log::error("Quiz submission failed: " . $e->getMessage());

//         return redirect()->route('/add-quiz-result')->with('error', 'Something went wrong! Please try again.');
//     }
// }

public function submit_quiz_result(Request $request)
{
     $validated = $request->validate([
        'match_name' => 'required|string',
        'q1' => 'required|string',
        'q2' => 'required|string',
        'q3' => 'required|string',
        'q4' => 'required|string',
        'q5' => 'required|string',
        'created_at' => 'required|date',
    ]);

    try {
         $createdAt = date('Y-m-d H:i:s', strtotime($request->created_at . ' ' . now()->format('H:i:s')));

        DB::table('quiz_answer')->insert([
            'match_name' => $request->match_name,
            'q1' => $request->q1,
            'q2' => $request->q2,
            'q3' => $request->q3,
            'q4' => $request->q4,
            'q5' => $request->q5,
            'created_at' => $createdAt,
            'updated_at' => now(),
        ]);

        return redirect()->route('/quiz-result-list')->with('success', 'Quiz submitted successfully!');
    } catch (\Exception $e) {
        Log::error("Quiz submission failed: " . $e->getMessage());
        return redirect()->route('/add-quiz-result')->with('error', 'Something went wrong! Please try again.');
    }
}



function delete_quiz_result($id)
{
    DB::table('quiz_answer')->where('id', $id)->delete();
    return response()->json(['success' => 'Record deleted successfully.']);
}
function quiz_register_user(){
    $quizregister = DB::table('khelo_myitr_register')->orderBy('id', 'DESC')->get();
    //   print_r($quizregister);die;
    return view('myitr_quiz.quiz_register_user', compact('quizregister'));
}
function user_quiz_submit(){
    $quizsubmit = DB::table('myqize_myitr')->orderBy('id', 'DESC')->get();
    //   print_r($quizsubmit);die;
    return view('myitr_quiz.user_quiz_submit', compact('quizsubmit'));
    
}
function ipl_match_list2025(){
    $ipl_matches_2025 = DB::table('ipl_matches_2025')
    // ->whereDate('match_date2', '>=', Carbon::today()) // Aaj ki date aur uske baad wale matches
    ->orderBy('match_date2', 'DESC') // Sabse pehle aane wale match
    ->get();
    //   print_r($ipl_matches_2025);die;
    return view('myitr_quiz.ipl_match_list2025', compact('ipl_matches_2025')); 
}
public function edit($id)
{
    $match = DB::table('ipl_matches_2025')->where('id', $id)->first();
    return view('myitr_quiz.match_edit', compact('match'));
}

public function update(Request $request, $id)
{
    DB::table('ipl_matches_2025')->where('id', $id)->update([
        'match_number' => $request->match_number,
        'match_date'   => $request->match_date,
        'match_date2'  => $request->match_date2,
        'location'     => $request->location,
        'rival'        => $request->rival,
        'match_time'   => $request->match_time,
    ]);

    return redirect('administrator/ipl-match-list2025')->with('success', 'Match updated successfully.');
}

}
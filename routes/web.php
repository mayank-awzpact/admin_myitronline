<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MyitrQuizController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EcaRequestController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\GuidesController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Form16Controller;
use App\Http\Controllers\BulkMailController;
use App\Http\Controllers\UtmController;
use UniSharp\LaravelFileManager\Lfm;
use Livewire\Volt\Volt;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\WhatsAppCsvController;
use App\Http\Controllers\SpinAndWinController;
use Illuminate\Support\Facades\Mail;



Route::get('/mail-test', function () {
    \Mail::raw('This is a test email from Laravel', function ($message) {
        $message->to('developerdev909@gmail.com')
                ->subject('Laravel Test Email');
    });

    return 'Email sent!';
});

Route::post('/send-test-mail', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
    ]);

    try {
        Mail::raw('This is a test email from Laravel via API', function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Laravel Test Email from API');
        });

        return response()->json([
            'success' => true,
            'message' => 'Email sent to ' . $request->email,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
});


Volt::route('administrator/login', 'pages.auth.login')->name('login');
Route::get('/', function () {
    return redirect()->route('login');
});

    Route::prefix('administrator')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::prefix('eca_request')->group(function () {
        Route::get('/', [EcaRequestController::class, 'index'])->name('eca_request.index');
    });

    Route::prefix('form16')->group(function () {
        Route::get('/', [Form16Controller::class, 'index'])->name('form16.index');
        Route::get('/direct', [Form16Controller::class, 'direct_form16'])->name('form16.direct');
    });


    Route::prefix('order')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('order.index');
        Route::get('order.oldorder', [OrderController::class, 'old_oders'])->name('order.oldorder');
        Route::get('order.consultancy', [OrderController::class, 'consultancy'])->name('order.consultancy');
        Route::get('order.form16_payment', [OrderController::class, 'form16_payment'])->name('order.form16_payment');
    });

    Route::prefix('rent_recipts')->group(function () {
        Route::get('/', [RentController::class, 'index'])->name('rent.index');
    });



         Route::prefix('bulk_mail')->group(function () {
            Route::get('/', [BulkMailController::class, 'index'])->name('bulkmail.index');
            Route::get('/create', [BulkMailController::class, 'create'])->name('bulkmail.create');
            Route::post('/store', [BulkMailController::class, 'store'])->name('bulkmail.store');
            Route::get('/edit/{id}', [BulkMailController::class, 'edit'])->name('bulkmail.edit');
            Route::put('/update/{id}', [BulkMailController::class, 'update'])->name('bulkmail.update');
            Route::delete('/delete/{id}', [BulkMailController::class, 'destroy'])->name('bulkmail.destroy');
            Route::POST('/bulk_mail_send', [BulkMailController::class, 'bulk_mail_send'])->name('bulkmail.bulk_mail_send');
            Route::POST('/multiple-bulk-mail-send', [BulkMailController::class, 'sendBulk'])->name('bulkmail.send.bulk_mail');

        });

        Route::prefix('utm')->group(function () {
            Route::get('/', [UtmController::class, 'index'])->name('utm.index');
        });

        Route::prefix('spin')->group(function () {
        Route::get('/', [\App\Http\Controllers\SpinAndWinController::class, 'index'])->name('spin.index');
         });


      Route::prefix('whatsapp')->group(function () {
    Route::get('/', [WhatsAppController::class, 'showForm'])->name('whatsapp.index');
    // Route::post('/send', [WhatsAppController::class, 'sendMessages'])->name('whatsapp.send');
    // Route::post('/whatsapp/send', [WhatsAppController::class, 'sendMessages'])->name('whatsapp.send');
    Route::post('/whatsapp/send', [WhatsAppController::class, 'sendMessages'])->name('whatsapp.send');


});

Route::prefix('whatsapp')->group(function () {
    Route::get('/', [WhatsAppCsvController::class, 'showForm'])->name('whatsapp.index');
    Route::post('/send', [WhatsAppCsvController::class, 'sendFromCsv'])->name('whatsapp.csv.send');
});

    //quiz work
Route::get('/ipl-match-list2025', [MyitrQuizController::class, 'ipl_match_list2025'])->name('ipl-match-list2025');
Route::get('match/edit/{id}', [MyitrQuizController::class, 'edit'])->name('ipl-match-edit');
Route::post('match/update/{id}', [MyitrQuizController::class, 'update'])->name('ipl-match-update');

Route::get('/quiz-register-user', [MyitrQuizController::class, 'quiz_register_user'])->name('quiz-register-user');
Route::get('/user-quiz-submit', [MyitrQuizController::class, 'user_quiz_submit'])->name('user-quiz-submit');
Route::get('/quiz-result-list', [MyitrQuizController::class, 'quizresult_list'])->name('/quiz-result-list');
Route::get('/add-quiz-result', [MyitrQuizController::class, 'add_quiz_result'])->name('/add-quiz-result');
Route::post('/submit-quiz-result', [MyitrQuizController::class, 'submit_quiz_result'])->name('/submit-quiz-result');
Route::delete('delete-quiz-result/{id}', [MyitrQuizController::class, 'delete_quiz_result'])->name('delete-quiz-result');





    Route::prefix('services')->group(function () {
        Route::get('/', [ServicesController::class, 'index'])->name('services.index');
        Route::get('/create', [ServicesController::class, 'create'])->name('services.create');
        Route::post('/store', [ServicesController::class, 'store'])->name('services.store');
        Route::get('/edit/{id}', [ServicesController::class, 'edit'])->name('services.edit');
        Route::post('/update/{id}', [ServicesController::class, 'update'])->name('services.update');
        Route::delete('/delete/{id}', [ServicesController::class, 'destroy'])->name('services.destroy');
        Route::get('/servicemeta', [ServicesController::class, 'servicemeta'])->name('services.servicemeta');
        Route::post('/meta-store', [ServicesController::class, 'meta_store'])->name('services.meta_store');
        Route::get('/meta/create', [ServicesController::class, 'meta_create'])->name('services.meta_create');
        Route::get('/meta/edit/{id}', [ServicesController::class, 'meta_edit'])->name('services.meta_edit');
        Route::post('/meta/update/{id}', [ServicesController::class, 'meta_update'])->name('services.meta_update');
        Route::delete('/meta/delete/{id}', [ServicesController::class, 'meta_delete'])->name('services.meta_delete');
    });


    Route::prefix('guides')->group(function () {
        Route::get('/', [GuidesController::class, 'index'])->name('guides.index');
        Route::get('/create', [GuidesController::class, 'create'])->name('guides.create');
        Route::post('/store', [GuidesController::class, 'store'])->name('guides.store');
        Route::get('/edit/{id}', [GuidesController::class, 'edit'])->name('guides.edit');
        Route::put('/update/{id}', [GuidesController::class, 'update'])->name('guides.update'); // ✅ Corrected method to PUT
        Route::delete('/delete/{id}', [GuidesController::class, 'destroy'])->name('guides.destroy');
    });




    Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/form', [UserController::class, 'create'])->name('users.form');
    Route::post('/', [UserController::class, 'store'])->name('users.store');

    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update');

    Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/trash', [UserController::class, 'view_trash'])->name('users.trash');
    Route::post('/restore/{id}', [UserController::class, 'restore'])->name('users.restore');
});





    Route::view('/profile', 'profile')->name('profile');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('login');
    })->middleware('throttle:5,1')->name('logout');
});

Route::group(['prefix' => 'filemanager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
});


require __DIR__.'/auth.php';




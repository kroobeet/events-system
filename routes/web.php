<?php

use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestEmailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrganizationController;
use App\Http\Middleware\CheckRole;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    // Генерация изображения QR-кода
    $qrCode = new QrCode($user->qr_code);
    $writer = new PngWriter();
    $qrCodeImage = $writer->write($qrCode)->getDataUri();

    return view('dashboard', compact('qrCodeImage'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Маршруты профиля
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::middleware(CheckRole::class . ':manager,employee')->group(function () {
        // Маршруты мероприятий доступные в том числе сотрудникам
        Route::get('events', [EventController::class, 'index'])->name('events.index');
        Route::get('events/show/{event_id}', [EventController::class, 'show'])->name('events.show');
        Route::get('events/{id}/addComment/{participant_id}', [EventController::class, 'addComment'])->name('events.addComment');
        Route::post('events/{id}/addComment/{participant_id}', [EventController::class, 'commentStore'])->name('events.addedCommentStore');

        // Маршруты для QR-кода (сканирование и валидация)
        Route::get('events/{event_id}/scan-qr', [EventController::class, 'qrScanner'])->name('events.scan.qr');
        Route::get('events/{event_id}/validate-qr/{qr_code}', [EventController::class, 'qrValidate'])->name('events.validate.qr');

        Route::middleware(CheckRole::class . ':manager')->group(function () {
            // Маршруты для регистрации новых пользователей
            Route::get('register-user', [RegisterUserController::class, 'create'])->name('user-register');
            Route::post('register-user', [RegisterUserController::class, 'store']);

            // Маршруты для мероприятий
            Route::get('events/edit/{event_id}', [EventController::class, 'edit'])->name('events.edit');
            Route::post('events/update/{event_id}', [EventController::class, 'update'])->name('events.update');
            Route::get('events/create', [EventController::class, 'create'])->name('events.create');
            Route::post('events/store', [EventController::class, 'store'])->name('events.store');
            Route::delete('events/destroy/{event_id}', [EventController::class, 'destroy'])->name('events.destroy');
            Route::post('events/{id}/attach-participant', [EventController::class, 'attachParticipant'])
                ->name('events.attachParticipant');
            Route::post('events/{id}/detach-participant/{participant_id}/', [EventController::class, 'detachParticipant'])
                ->name('events.detachParticipant');


            // Маршруты для пользователи
            Route::get('users', [UserController::class, 'index'])->name('users.index');
            Route::get('users/show/{user_id}', [UserController::class, 'show'])->name('users.show');
            Route::get('users/edit/{user_id}', [UserController::class, 'edit'])->name('users.edit');
            Route::delete('users/destroy/{user_id}', [UserController::class, 'destroy'])->name('users.destroy');
            Route::put('users/update/{user_id}', [UserController::class, 'update'])->name('users.update');

            // Маршруты для организаций
            Route::get('organizations', [OrganizationController::class, 'index'])->name('organizations.index');
            Route::get('organizations/create', [OrganizationController::class, 'create'])->name('organizations.create');
            Route::post('organizations', [OrganizationController::class, 'store'])->name('organizations.store');
            Route::get('organizations/show/{organization}', [OrganizationController::class, 'show'])->name('organizations.show');
            Route::get('organizations/edit/{organization}', [OrganizationController::class, 'edit'])->name('organizations.edit');
            Route::post('organizations/update/{organization}', [OrganizationController::class, 'update'])->name('organizations.update');
            Route::delete('organizations/destroy/{organization}', [OrganizationController::class, 'destroy'])->name('organizations.destroy');
        });
    });
});

Route::get('/send-test-email', [TestEmailController::class, 'sendTestEmail']);



require __DIR__ . '/auth.php';

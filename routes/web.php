<?php

use App\Http\Controllers\Web\Booking\BookingController;
use App\Http\Controllers\Web\ContactUs\ContactUsController;
use App\Http\Controllers\Web\Course\CourseController;
use App\Http\Controllers\Web\Home\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([], function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('about_us', [HomeController::class, 'get_about_us'])->name('about_us');
    Route::get('career', [HomeController::class, 'get_career_page'])->name('career');
    Route::post('career', [HomeController::class, 'career_submit'])->name('career.submit');
    Route::get('contact_us', [ContactUsController::class, 'index'])->name('contact_us');
    Route::post('contact_us', [ContactUsController::class, 'store'])->name('contact_us.submit');
    Route::get('/page/{page}/{title?}', fn(\App\Models\Page $page) => view('pages.show', ['model' => $page]))->name('pages.show');
});

Route::group(['prefix' => 'courses'], function () {
    Route::get('/', [CourseController::class, 'index'])->name('courses.ages');
    Route::get('course/{course}/{name?}', [CourseController::class, 'show'])->name('courses.show');
});
Route::group(['prefix' => 'follow_up'], function () {
    Route::get('/sessions/{child_id}/{course_id}', [\App\Http\Controllers\Web\FollowUp\FollowUpController::class, 'sessions'])->name('followup.sessions');
    Route::get('/', [\App\Http\Controllers\Web\FollowUp\FollowUpController::class, 'index'])->name('followup');
    Route::get('/index_details', [\App\Http\Controllers\Web\FollowUp\FollowUpController::class, 'child_details'])->name('followup.ChildDetails');
    Route::get('follow_up_details/{session_review}', [\App\Http\Controllers\Web\FollowUp\FollowUpController::class, 'show_sessions'])->name('followup.details');
});

Route::group(['prefix' => 'bookings'], function () {
    Route::get('booking', [BookingController::class, 'index'])->name('booking');
    Route::get('courses', [BookingController::class, 'get_courses'])->name('booking.courses');
    Route::post('booking', [BookingController::class, 'store'])->name('booking.store');
    Route::view('success', 'Booking.success')->name('booking.success');
});

Route::group(['prefix' => 'payment'], function () {
    Route::get('/', [BookingController::class, 'get_payment_page'])->name('payment');

});

Route::get('login-fix', fn() => redirect(config('filament.path') . '/login'))->name('login');
Route::any('locale/{locale}', function ($locale) {
    session()->put('locale', $locale);
    return request()->header('Referer') ? redirect(request()->header('Referer')) : redirect()->back();
})->name('change_locale');

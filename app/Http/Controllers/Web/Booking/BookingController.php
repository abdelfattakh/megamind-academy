<?php

namespace App\Http\Controllers\Web\Booking;

use App\Http\Controllers\Web\WebController;
use App\Http\Requests\CreateBookingRequest;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Country;
use App\Models\Course;
use App\Models\PaymentMethod;
use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends WebController
{
    /**
     * Get Booking Page.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $countries = Country::active()->get();
        $categories = Category::active()->get();
        $subscriptions = Subscription::active()->get();

        return view('Booking.booking')->with([
            'countries' => $countries,
            'categories' => $categories,
            'subscriptions' => $subscriptions,
            'course_id' => $request->course_id ?? null
        ]);
    }

    // TODO: This Method needs refactoring.
    public function store(CreateBookingRequest $request): RedirectResponse
    {
        Booking::query()->create($request->validated());
        return redirect()->route('booking.success')->with(['message' => 'Thanks for Booking with ' . config('app.name')]);
    }

    /**
     * Get Courses for Booking Form.
     * @param Request $request
     * @return JsonResponse
     */
    public function get_courses(Request $request):JsonResponse
    {
        $courses = Course::query()->active()->where('category_id', $request->category_id)->get();
        $html = view('Booking.courses', [
            'courses' => $courses,
        ])->render();
        return response()->json(['html' => $html]);
    }

    /**
     * Get Payment Page
     * @return View
     */
    public function get_payment_page():View
    {
      $payment_methods=PaymentMethod::query()->active()->with('image')->get();

      return view('payment.payment')->with([

          'payment_methods'=>$payment_methods
      ]);
    }
}

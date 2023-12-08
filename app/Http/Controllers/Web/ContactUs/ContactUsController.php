<?php

namespace App\Http\Controllers\Web\ContactUs;

use App\Http\Controllers\Web\WebController;
use App\Http\Requests\ContactUsRequest;
use App\Models\ContactUs;
use App\Settings\ContactUsSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactUsController extends WebController
{
    /**
     * Get Contact Us Page
     * @param ContactUsSettings $contact_us
     * @return View
     */
    public function index(ContactUsSettings $contact_us): View
    {
        return view('contact_us.index')->with([
            'contact_us' => $contact_us
        ]);
    }

    /**
     * Submit Contact Us Submit
     * @param ContactUsRequest $request
     * @return RedirectResponse
     */
    public function store(ContactUsRequest $request): RedirectResponse
    {
        ContactUs::query()->create($request->validated());
        return redirect()->route('index')->with(['message' => 'Thanks for Contacting ' . config('app.name')]);
    }
}

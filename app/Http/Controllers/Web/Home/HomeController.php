<?php

namespace App\Http\Controllers\Web\Home;

use App\Http\Controllers\Web\WebController;
use App\Http\Requests\CareerRequest;
use App\Models\Age;
use App\Models\Career;
use App\Models\Position;
use App\Models\Program;
use App\Models\Review;
use App\Settings\AboutUsSettings;
use App\Settings\ContactUsSettings;
use App\Settings\JoinUsSettings;
use App\Settings\ProgramStructure;
use App\Settings\StatisticsSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class HomeController extends WebController
{
    /**
     * Get Index Page.
     *
     * @param StatisticsSettings $statistics
     * @param ContactUsSettings $contactUs
     * @param ProgramStructure $structure
     * @return View
     */
    public function index(StatisticsSettings $statistics, ContactUsSettings $contactUs, ProgramStructure $structure): View
    {
        $ages = Cache::remember(
            key: 'home-ages-cache',
            ttl: now()->addMinutes(60),
            callback: fn() => Age::active()->with(['image', 'courses.category'])->get(),
        );

        $reviews = Cache::remember(
            key: 'home-reviews-cache',
            ttl: now()->addMinutes(60),
            callback: fn() => Review::active()->with('image')->get(),
        );

        $programs = Cache::remember(
            key: 'home-programs-cache',
            ttl: now()->addMinutes(60),
            callback: fn() => Program::active()->with('image')->get(),
        );

        return view('home.index')->with([
            'statistics' => $statistics,
            'contactUs' => $contactUs,
            'structure' => $structure,
            'ages' => $ages,
            'reviews' => $reviews,
            'programs' => $programs
        ]);
    }

    /**
     * Get About Us Page.
     *
     * @param AboutUsSettings $about_us
     * @param StatisticsSettings $statistics
     * @return View
     */
    public function get_about_us(AboutUsSettings $about_us, StatisticsSettings $statistics): View
    {
        return view('about_us.index')->with([
            'statistics' => $statistics,
            'about_us' => $about_us,
        ]);
    }

    /**
     * Get Careers Page.
     *
     * @param JoinUsSettings $career
     * @return View
     */
    public function get_career_page(JoinUsSettings $career): View
    {
        $positions = Position::active()->get();
        return view('careers.index')->with([
            'career' => $career,
            'positions' => $positions
        ]);
    }

    /**
     * Submitting Career Form.
     *
     * @param CareerRequest $request
     * @return RedirectResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function career_submit(CareerRequest $request): RedirectResponse
    {
        /** @var Career $career */
        $career = Career::query()->create($request->validated());
        if ($request->hasFile('careerFile')) {
            $career->addMediaFromRequest('careerFile')->toMediaCollection((new Career())->getPrimaryMediaCollection());
        }
        return redirect()->route('index')->with(['message' => __('web.apply_success')]);
    }
}

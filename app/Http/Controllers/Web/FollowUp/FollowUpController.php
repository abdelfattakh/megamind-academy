<?php

namespace App\Http\Controllers\Web\FollowUp;

use App\Http\Controllers\Web\WebController;
use App\Http\Requests\FollowUpRequest;
use App\Models\Child;
use App\Models\ChildSessionReview;
use App\Models\Course;
use App\Settings\ChildSessionReviewSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FollowUpController extends WebController
{
    /**
     * return follow up page
     * @return View
     */
    public function index(): View
    {

        return view('followup.followup-index');
    }

    /**
     * show child sessions
     * @param FollowUpRequest $request
     * @return View|RedirectResponse
     */
    public function sessions($id, $courseId): View|RedirectResponse
    {

        $child = Child::find($id);

        $session_reviews = $child->session_reviews()
            ->with('session_entry.work_shop') // Assuming 'session_entry' is the relation name
            ->whereRelation('session_entry', 'course_id', $courseId)
            ->get();

        if (!filled($child)) {
            return redirect()->route('followup');
        }

        return view('followup.followup-sessions')->with(['child' => $child,'session_reviews'=>$session_reviews]);
    }

    /**
     * show child sessions
     *
     * @param FollowUpRequest $request
     * @param ChildSessionReviewSettings $child_review
     * @return View|RedirectResponse
     */
    public function child_details(FollowUpRequest $request, ChildSessionReviewSettings $child_review): View|RedirectResponse
    {
        $child = Child::query()
            ->with(['session_reviews.session_entry.work_shop', 'image'])
            ->find($request->validated('child_id'));

        if (!filled($child) || !filled($child->getRelation('session_reviews'))) {
            return redirect()->route('followup')->withErrors(['child_id' => __('web.child_not_found_in_our_academy')]);
        }

        $courses = $child->getRelation('session_reviews')
            ->pluck('session_entry.course_id')
            ->unique()
            ->filter()
            ->mapWithKeys(function (int $courseId, $key) use ($child_review, $child) {
                return [
                    $courseId => [
                        'count' => $child->getRelation('session_reviews')->where('session_entry.course_id', $courseId)->count(),
                        'workshop' => $child->getRelation('session_reviews')->where('session_entry.course_id', $courseId)->first()->session_entry->work_shop->toArray(),
                        'avg' => [
                            'attendance' => $child->getRelation('session_reviews')->where('session_entry.course_id', $courseId)->avg('attendance') * 100,
                            ...collect($child_review->booleans)->mapWithKeys(fn($b) => ["$b" => $child->getRelation('session_reviews')->where('session_entry.course_id', $courseId)->avg("data.$b") * 100]),
                            ...collect($child_review->ratings)->mapWithKeys(fn($b) => ["$b" => $child->getRelation('session_reviews')->where('session_entry.course_id', $courseId)->avg("data.$b") / 5 * 100]),
                        ],
                    ],
                ];
            })
            ->map(function (array $course) {
                $course['overall'] = collect($course['avg'])->avg();
                return $course;
            });

        return view('followup.followup-child_details', compact('courses','child'));
    }

    public function show_sessions(ChildSessionReview $sessionReview): View
    {
        $sessionReviewrelation = $sessionReview->load(['session_entry' => fn($q) => $q->with('work_shop')]);

        return view('followup.folllowup-session-details')->with(['sessionReviewrelation' => $sessionReviewrelation]);
    }
}

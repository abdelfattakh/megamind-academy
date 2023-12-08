<?php

namespace App\Http\Controllers\Web\Course;

use App\Http\Controllers\Web\WebController;
use App\Models\Age;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends WebController
{
    /**
     * Get Course By Id.
     *
     * @param Course $course
     * @param string|null $name
     * @return View
     */
    public function show(Course $course, ?string $name = null): View
    {
        // TODO: we should eager load $prerequisites
        $prerequisites = Course::query()
            ->whereIn('id', $course->prerequisites)
            ->active()
            ->get();
        $courses = Course::query()
            //->where('category_id', $course->category_id)
            ->where('id', '!=' , $course->getKey())
            ->with('image')
            ->active()
            ->get();

        $course->loadMissing('image');

        return view('Courses.courseDetails')->with([
            'model' => $course,
            'prerequisites' => $prerequisites,
            'models' => $courses,
        ]);
    }

    /**
     * Get Courses Page.
     *
     * @param Request $request
     * @return JsonResponse|View
     */
    public function index(Request $request): JsonResponse|View
    {
        $ages = Age::active()->get();
        $id = $ages->firstWhere('id', $request->integer('id'))?->id ?? $ages->first()->id;

        $categories = Category::query()
            ->withWhereHas('courses', function (Builder|HasMany $query) use ($id) {
                $query->whereHas('ages', fn(Builder|HasMany $q) => $q->where('ages.id', $id)) // filter by age.
                ->active()
                ->with('image'); // attach courses image.
            })
            ->get();

        if ($request->ajax()) {
            $html = view('Courses.render', [
                'categories' => $categories,
                'id' => $id,
                'ages' => $ages,

            ])->render();

            return response()->json(['html' => $html]);
        }

        return view('Courses.course')->with([
            'id' => $id,
            'ages' => $ages,
            'categories' => $categories,
        ]);
    }
}

<section class="courses container mb100">
    <div class="head_title">
        <span>[</span>
        <h2> {{__('web.top_courses')}} </h2>
        <span>]</span>
    </div>
    <div class="items">
        @foreach($courses as $course)
            @include('common.courseCard')
        @endforeach
    </div>
    <a href="{{route('courses.ages')}}" class="btn_page2">{{__('admin.more_courses')}}</a>
</section>

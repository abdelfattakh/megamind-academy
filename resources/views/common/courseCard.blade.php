<div class="part mb100">
    <div class="headCoursers">

        <h3 class="wow slideInLeft" data-wow-duration="1s">{{$category->name}}</h3>
        <span></span>
    </div>
    <div class="items" id="items">

        @foreach($category->courses as $course)
            @include('Courses.card', ['course' => $course])
        @endforeach
    </div>
</div>





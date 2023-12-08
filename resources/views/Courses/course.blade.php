@extends('layout.app', ['current_page' => 'courses'])

@section('body')
    @include('Courses.header')
    @php
        $no_courses = __('web.no_courses_yet');
        $check_it_later =__('web.check_it_later');
    @endphp


    <section class="courses  ">
        <div class="container">
            <div class="btn_age">
                @foreach($ages as $age)
                 <a>  <button id="{{$age->id}}"
                              onclick="getAgeCourses(this,{{$age->id}})"
                            @if(isset($id)&&$id == $age->id)class="active ages"
                            @elseif(!isset($id) &&$loop->first)class="active ages"
                            @else class="ages" @endif>{{$age->name}}
                     </button>
                @endforeach
            </div>
            <div id="render">
                @if($categories->isEmpty())
                    <div class="itemsEmpty">
                        <img src="{{asset('frontend/images/emptyCourses.webp')}}" alt="emptyCourses">
                        <h2>{{__('web.no_courses_yet')}}</h2>
                        <p>{{__('web.check_it_later')}}</p>
                    </div>
                @endif

                @foreach($categories as $category)
                    @include('common.courseCard')
                @endforeach
            </div>
        </div>
    </section>

@endsection
@pushonce('scripts')
    <script>
        function getAgeCourses(age, id) {
            var myElement = document.querySelector('.active.ages');
            myElement.classList.remove('active');
            age.classList.add('active')

            $('#render').html(`<div class="spinner-border text-primary itemsEmpty" role="status">
                <span class="sr-only">Loading...</span>
            </div>`)
            var url = '{{ route("courses.ages", ":id") }}';
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,


                },
                headers: {
                    "Accept-Language": "{{ app()->getLocale() }}",
                    "Accept": "application/json"
                },

                success: function (response) {
                    console.log(response)
                    if (response.html === '') {
                        $('#render').html(`<div class="itemsEmpty">
                        <img src="../../frontend/images/emptyCourses.webp" alt="emptyCourses">
                             <h2>@json($no_courses)</h2>
                             <p>@json($check_it_later)</p>
                             </div>`)
                    } else {
                        $('#render').html(response.html)
                    }
                },
                error: function (error) {
                    console.log(error)
                },
            });
        }
    </script>

@endpushonce

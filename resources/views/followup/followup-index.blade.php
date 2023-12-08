@extends('layout.app',['current_page' => 'follow_up_index'])
@section('body')
    <section class="Follow-Up Follow-UpEmpty container">
        <h2><span>{{__('web.follow_up_your_kid')}}</span></h2>
        <img src="{{asset('frontend/images/successPage.webp')}}" alt="successPage" />

        <p>{{__('web.follow_attendance')}}</p>
        <form action="{{route('followup.ChildDetails')}}" method="get" class="row g-3 form_page">
            <div class="col-md-12">
                <label for="inputFirstName" class="form-label"
                >{{__('web.student_code')}} <span>*</span></label
                >
                <input
                    type="text"
                    class="form-control"
                    id="inputFirstName"
                    name="child_id"
                    placeholder="{{__('web.please_enter_code')}}"
                />
                @include('alerts.inline-error', ['field' => 'child_id'])
            </div>
            <input type="submit" class="btn_page" value="{{__('web.enter_code')}}">
        </form>
    </section>


@endsection

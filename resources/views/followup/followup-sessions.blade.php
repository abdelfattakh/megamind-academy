@extends('layout.app', ['current_page' => 'follow_up_sessions'])
@section('body')
    <section class="account container mb100">

        @if(filled($child->session_reviews))

            <div class="Profile followUp acount_part2">
                <h2 class="acountTitle1">{{__('web.follow_up_your_kid')}}</h2>
                <div class="btnFollow">


                </div>
                <div class="items">

                    @foreach($session_reviews as $session_review)
                        <div class="item">
                            <h3>{{$session_review->session_entry->work_shop->course_name?? __('web.unknown')}}</h3>
                            <ul>
                                <li class="@if($session_review->attendance==0) absent @else attended @endif">
                                    <h4>{{__('web.Attendance_status')}}</h4>

                                    {{$session_review->attendance == 1? __('web.attendant') : __('web.absent')}}
                                </li>

                                <li>
                                    <h4>{{__('web.session_name')}}</h4>
                                    <h5>{{$session_review->session_entry?->work_shop?->course_name ?? __('web.unknown')}}</h5>
                                </li>

                                <li>
                                    <h4>{{__('web.doc_date')}}</h4>
                                    @if($session_review->session_entry?->doc_date)
                                        <h5>{{Carbon\Carbon::parse($session_review->session_entry?->doc_date)->format('Y-m-d')}}</h5>
                                    @else
                                        {{ __('web.unknown') }}
                                    @endif
                                </li>

                                <li>
                                    <h5>
                                    <span>
                                        @if($session_review->attendance == 1)
                                            <a href="{{route('followup.details',['session_review'=>$session_review])}}"
                                               class="see">{{__('web.see_details')}}</a>
                                        @endif
                                    </span>
                                    </h5>
                                </li>
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="emptyfollow empty acount_part2  ">
                <img src="{{asset('frontend/images/emptyfollow.webp')}}" alt="emptyfollow"/>
                <h3>{{__('web.no_sessions_added')}}</h3>
            </div>
        @endif
    </section>

@endsection

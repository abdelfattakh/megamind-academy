@extends('layout.app', ['current_page' => 'follow_up_details'])
@section('body')

    <section class="account container mb100">
        <div class="Profile followUp followUpdetails acount_part2">
            <h2 class="acountTitle1">{{__('web.follow_up_your_kid')}}</h2>
            <div class="items">
                <div class="item">
                    <h3>{{$sessionReviewrelation->session_entry?->work_shop?->course_name}}</h3>
                    <ul>
                        <li class="attended">{{__('web.attendant')}}</li>

                        <li>
                            <h4>{{__('web.session_name')}}</h4>
                            <h5>{{$sessionReviewrelation->session_entry?->work_shop?->course_name}}</h5>
                        </li>

                        <li>
                            <h4>{{__('web.doc_date')}}</h4>
                            <h5>{{Carbon\Carbon::parse($sessionReviewrelation->session_entry?->doc_date)->format('Y-m-d')}}</h5>
                        </li>

                        @if(filled($sessionReviewrelation->session_entry?->instructor_name))
                            <li>
                                <h4>{{__('web.instructor_name')}}</h4>
                                <h5>{{$sessionReviewrelation->session_entry?->instructor_name}}</h5>
                            </li>
                        @endif

                        <li>
                            <h5>
                                <span></span>
                            </h5>
                        </li>
                    </ul>
                </div>
            </div>

            @if(filled($sessionReviewrelation->data))
                <h3 class="titleh3">{{__('web.instructor_evaluation')}}</h3>
                <ul class="instructor">
                    <li>
                        @foreach($sessionReviewrelation->data as $key => $value)
                            @if(filled($value))
                                <h4>{{$key}}</h4>
                                <h5></h5>
                                <div class="allStars">
                                    @if(is_numeric($value))
                                        @for($i=0;$i<$value;$i++)
                                            <img src="{{asset('frontend/images/stars.svg')}}" alt="stars">
                                        @endfor
                                    @elseif(is_bool($value))
                                        <h5>{{$value==true?'✅':"❌"}}</h5>
                                    @else
                                        <h5>{{$value}}</h5>

                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </li>
                </ul>
            @else
                <h3 class="titleh3">{{__('web.instructor_not_evaluating')}}</h3>
            @endif
        </div>
    </section>
@endsection

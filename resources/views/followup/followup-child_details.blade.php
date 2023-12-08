@extends('layout.app',['current_page' => 'follow_up_child_details'])
@section('body')
    <section class="account container mb100">
        @if(filled($child->session_reviews))
            <div class="Profile followUp acount_part2">
                <h2 class="acountTitle1">{{__('web.follow_up_your_kid')}}</h2>
                <div class="btnFollow">
                </div>

                @foreach($courses as $course)

                    <div class="table-wrapper">
                        <table class="table">
                            <tr>
                                <td class="t-regular">{{__('web.child_name')}}</td>
                                <td>{{$child->name}}  </td>
                                <td  rowspan="4" colspan="{{collect(collect($course)->get('avg'))->count()-2}}" style="padding: 0; position: relative;">
                                    <a class="seeDetails" href="{{route('followup.sessions',['child_id'=>$child->id,'course_id'=>collect($course)->get('workshop')['course_id']])}}">
                                        <p>{{__('web.see_details')}}</p>
                                        <img src="{{asset('frontend/images/Arrow.svg')}}" alt="Arrow">
                                    </a>
                                    @if($child->relationLoaded('image') && $child->getRelation('image'))
                                        {{ $child->getRelation('image')?->img('', ['alt' => $child->getAttribute('name'),'class'=>'child', 'onerror' => "this.src='" . asset('icon.png') . "'"]) }}
                                    @else
                                        <img class="child" src="{{asset('icon.png')}}" alt=""/>
                                    @endif
                                </td>
                            </tr>
                            <tr>

                                <td class="t-regular">{{__('admin.course_name')}}</td>
                                <td>{{collect($course)->get('workshop')['course_name']}}</td>
                            </tr>
                            <tr>
                                <td class="t-regular">{{__('web.no_of_sections')}}</td>
                                <td>{{collect($course)->get('count')}}</td>
                            </tr>
                            <tr>

                                <td class="t-regular">{{__('web.evaluation')}}</td>

                                <td>{{number_format(collect($course)->get('overall'),0)}}%</td>
                            </tr>

                            <tr>
                                <td class="t-regular">{{__('admin.attendance')}}</td>
                                @foreach(collect(collect($course)->get('avg'))->except('attendance') as $key => $value)
                                    <td style=" text-align: center;" class="t-regular">{{$key}}</td>
                                @endforeach


                            </tr>

                            <tr>
                                <td style=" text-align: center;">
                                    {{number_format(collect($course)->get('avg')['attendance'],0)}}%
                                </td>
                               @foreach(collect(collect($course)->get('avg'))->except('attendance') as $key=>$value)
                                <td style=" text-align: center;">
                                    {{number_format($value,0)}}%
                                </td>
                                @endforeach


                            </tr>
                        </table>
                    </div>
                @endforeach
            </div>
        @else
            <div class="emptyfollow empty acount_part2">
                <img src="{{asset('frontend/images/emptyfollow.webp')}}" alt="emptyfollow"/>
                <h3>{{__('web.no_sessions_added')}}</h3>
            </div>
        @endif
    </section>
@endsection

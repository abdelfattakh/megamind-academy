@php
    /** @var \App\Settings\ProgramStructure $structure */
@endphp

<Section class="structure">
    <img src="{{asset('frontend/images/network.webp')}}" alt="network" class="network">
    <div class="head_title">
        <span>[</span>
        <h2> {{__('web.program_structure')}} </h2>
        <span>]</span>
    </div>
    <div class="parts container">
        <div class="part1">
            <img src="{{asset('frontend/images/structure.webp')}}" alt="Structure">
        </div>
        <div class="part2">
            <ul>
                <li>
                    <div class="tilteLi">
                        <img src="{{asset('frontend/images/Weekly-Hours.svg')}}" alt="Hours">
                        <h3>{{__('admin.weekly_hours')}}</h3>
                    </div>
                    <p>{{$structure->weekly_hours.' '.__('admin.hours')}}</p>
                </li>
                <li>
                    <div class="tilteLi">
                        <img src="{{asset('frontend/images/agerange.svg')}}" alt="Age">
                        <h3>{{__('admin.age_range')}}</h3>
                    </div>
                    <p>{{$structure->age_range}}</p>
                </li>
                <li>
                    <div class="tilteLi">
                        <img src="{{asset('frontend/images/Group-Size.svg')}}" alt="Group-Size">
                        <h3>{{__('web.group_size')}}</h3>
                    </div>
                    <p>{{$structure->group_size.' '.__('admin.students')}}</p>
                </li>
                <li>
                    <div class="tilteLi">
                        <img src="{{asset('frontend/images/Languages.svg')}}" alt="Languages">
                        <h3>{{__('admin.languages')}}</h3>
                    </div>
                    <p>{{$structure->languages}}</p>
                </li>
                <li>
                    <div class="tilteLi">
                        <img src="{{asset('frontend/images/Location.svg')}}" alt="Location">
                        <h3>{{__('admin.location')}}</h3>
                    </div>
                    <p>{{$structure->location}}</p>
                </li>
            </ul>
            <h4>{{__('admin.international_accreditation')}}</h4>
            <img src="{{asset('frontend/images/INTERNATIONAL.webp')}}" alt="International" class="International">
        </div>
    </div>
</Section>

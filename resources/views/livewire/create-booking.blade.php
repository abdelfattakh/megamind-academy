<div class="content">
    <h3 class="f-s">
        {{__('web.we_will_contact_you')}}
    </h3>

    <form class="row g-3 form_page" action="{{route('booking.store',['course_id'=>$course->id])}}" method="post">
        @csrf
        <div class="col-md-12">
            <label for="inputFirstName" class="form-label"
            >{{__('admin.first_name')}} <span>*</span></label
            >
            <input
                type="text"
                class="form-control"
                id="inputFirstName"
                placeholder="{{__('admin.first_name')}}"
                name="full_name"
                wire:model.defer="full_name"
                value="{{old('full_name')}}"

            />
            @include('alerts.inline-error', ['field' => 'full_name'])
        </div>
        <div class="col-md-12">
            <label for="inputParentName" class="form-label"
            >{{__('admin.parent_name')}} <span>*</span></label
            >
            <input
                type="text"
                class="form-control"
                id="inputParentName"
                name="parent_name"
                wire:model.defer="parent_name"
                placeholder="{{__('admin.parent_name')}}"
                value="{{old('parent_name')}}"
            />
            @include('alerts.inline-error', ['field' => 'parent_name'])
        </div>

        <div class="col-md-4 endDiv">
            <label for="inputState" class="form-label"
            >{{__('admin.date_of_birth')}}<span>*</span></label
            >
            <select name="day" wire:model.defer="day" id="inputState" class="form-select">
                <option selected>{{__('Day')}}</option>
                @for ($i = 1; $i <= 31; $i++)
                    <option value="{{ $i }}" @if (old('day') == $i) selected @endif>{{ $i }}</option>
                @endfor

            </select>
        </div>
        <div class="col-md-4 endDiv">
            <select name="month" wire:model.defer="month"  id="inputState" class="form-select">
                <option selected>{{__('Month')}}</option>
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" @if (old('month') == $i) selected @endif>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-4 endDiv">
            <select name="year" wire:model.defer="year" id="inputState" class="form-select">
                <option >{{__('Year')}}</option>
                @for ($i = date('Y'); $i >= 1900; $i--)
                    <option value="{{ $i }}" @if (old('year') == $i) selected @endif>{{ $i }}</option>
                @endfor
            </select>

        </div>

        <input type="hidden" id="country" name="phone_country">

        <div class="col-md-12">
            <label for="inputPhone " class="form-label"
            >{{__('web.phone')}} <span>*</span></label
            >

            <input
                type="tel"
                class="form-control"
                id="phone"
                name="phone"
                wire:model.defer="phone"


                placeholder="{{__('web.phone')}}"
                value="{{old('phone')}}"
            />
            @include('alerts.inline-error', ['field' => 'phone'])

        </div>
        <div class="col-md-12">
            <label for="inputEmail" class="form-label"
            >{{__('web.email')}} <span>*</span></label
            >
            <input
                type="email"
                class="form-control"
                id="inputEmail"
                placeholder="Email"
                name="email"
                wire:model.defer="email"
                value="{{old('email')}}"
            />
            @include('alerts.inline-error', ['field' => 'email'])

        </div>
        <div class="col-md-12">
            <label for="inputCity" class="form-label"
            >{{__('admin.country_PLURAL')}} <span>*</span></label
            >
            <select
                wire:change="updateSelectedCountry"
                wire:model.lazy="selectedCountry"
                id="inputCity" name="country_id" class="form-select">
                <option selected>{{__('admin.country_PLURAL')}}</option>
                @foreach($countries as $country)
                    <option value="{{$country->id}}">{{$country->name}}</option>
                @endforeach
            </select>
            @include('alerts.inline-error', ['field' => 'country_id'])
        </div>



        <div class="col-md-12">
            <label for="inputLocation" class="form-label"
            >{{__('web.location_of_the_course')}} <span>*</span></label
            >

                <div class="form-check">
                    <input
                        class="form-check-input location"
                        type="checkbox"
                        id="gridCheck1"
                        name="location_of_course"
                        wire:model.defer="location_of_course"
                        value="{{__(\App\Enums\CourseLocationEnum::Online()->value)}}"
                    />
                    <label class="form-check-label" for="gridCheck1"> {{__(\App\Enums\CourseLocationEnum::Online()->value)}} </label>
                </div>
            @include('alerts.inline-error', ['field' => 'location_of_course'])

        </div>
        <div class="col-md-12">
            <label for="inputLocation" class="form-label"
            >{{__('web.appropriate_date_attendance')}} <span>*</span>
                <p>{{__('web.choose_date_for_attendance')}}</p></label
            >
            @foreach(\App\Enums\DaysEnum::toArray() as $day)
                <div class="form-check">
                    <input
                        class="form-check-input dates"
                        type="checkbox"
                        id="gridCheck1"
                        name="days[]"
                        wire:model.defer="days"
                        value="{{$day}}"
                    />


                    <label class="form-check-label" for="gridCheck1">
                        {{__($day)}}
                    </label>
                </div>
            @endforeach
            @include('alerts.inline-error', ['field' => 'days'])
        </div>

        <input type="submit" value="Book" class="btn_page"/>
    </form>
</div>

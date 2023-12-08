<form class="form_Career" method="post" action="{{route('career.submit')}}" enctype="multipart/form-data">
    @csrf
    <div class="part1">
        <h3>{{__('web.open_position')}}</h3>
        @foreach($positions as $position)
            <div class="form-check">
                <input
                    class="form-check-input position"
                    type="checkbox"
                    value="{{$position->id}}"
                    name="position_id"
                    id="flexCheckDefault"
                />
                <label class="form-check-label" for="flexCheckDefault">
                    {{$position->name}}
                </label>
            </div>
        @endforeach
        @include('alerts.inline-error', ['field' => 'position_id'])
    </div>

    <div class="part2">
        <h3 class="f-b">{{__('web.we_will_glad')}}</h3>
        <div class="row g-3 form_page" >
            <div class="col-md-6">
                <label for="inputFirstName" class="form-label">
                    {{__('web.write_first_name_career')}} <span>*</span>
                </label>
                <input
                    type="text"
                    class="form-control"
                    id="inputFirstName"
                    name="first_name"
                    placeholder="{{__('web.first_name')}}"
                />
                @include('alerts.inline-error',['field'=>'first_name'])
            </div>

            <div class="col-md-6">
                <label for="inputLastName" class="form-label">
                    {{__('web.last_name')}}<span>*</span>
                </label>
                <input
                    type="text"
                    class="form-control"
                    id="inputLastName"
                    name="last_name"
                    placeholder="{{__('web.write_last_name')}}"
                />
                @include('alerts.inline-error',['field'=>'last_name'])
            </div>

            <div class="col-md-6">
                <label for="inputEmail" class="form-label">
                    {{__('web.email')}} <span>*</span>
                </label>
                <input
                    type="email"
                    class="form-control"
                    id="inputEmail"
                    name="email"
                    placeholder="{{__('web.write_email')}}"
                />
                @include('alerts.inline-error',['field'=>'email'])
            </div>

            <div class="upload col-12">
                <input type="file" id="fileupload" name="careerFile"/>
                <button>
                    <span class="plus">+</span>
                    <label>{{__('web.upload_your_cv')}} <span>*</span></label>
                </button>

                <div class="yourCV" id="yourCV">
                    <p class="filename" id="filename"></p>
                    <button><img src="{{asset('frontend/images/xCV.svg')}}" id="delet" alt="delet"></button>
                </div>
            </div>

            <div class="col-12">
                <label for="inputComment " class="form-label">{{__('web.comment')}}</label>
                <textarea
                    class="form-control"
                    name="comment"
                    cols="30"
                    rows="10"
                    placeholder="{{__('web.write_comment')}}"
                    id="inputComment"></textarea>
                @include('alerts.inline-error',['field'=>'comment'])
            </div>
            <input type="submit" value="{{__('web.send')}}" class="btn_page"/>
        </div>
    </div>
</form>

@pushonce('scripts')
    <script>
        const delet = document.getElementById("delet");
        const filename = document.getElementById("filename");
        const fileparent = document.getElementById("yourCV");

        delet.addEventListener("click",function(e){
            e.preventDefault()
            this.parentNode.parentElement.style.display="none";
        })

        if(filename.textContent.length <= 0){
            fileparent.style.display="none";
        }

        //now will select file name and print in div tag.
        //for this you need to pass parameter
        //will check in console first.
        // you have to go in target than file property
        $(function()
        {
            $("#fileupload").change(function(event) {
                var x = event.target.files[0].name
                $(".filename").text(x);
                if(x.length <= 1){
                    fileparent.style.display="none";
                }
                if(x.length > 1){
                    fileparent.style.display="flex";
                }
            });
        })
    </script>

    <script>
        $(".position").on("change", function () {
            $(".position").not(this).prop("checked", false);
        });
    </script>
@endpushonce

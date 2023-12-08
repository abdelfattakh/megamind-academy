@extends('layout.app', ['current_page' => 'profile'])

@section('body')
    <section class="account container mb100">
        <div class="linksAccount">
            <ul>
                <li>
                    <a href="{{route('profile')}}" class="active"> My Profile </a>
                </li>
                <li>
                    <a href="followUp.html"> Follow-Up </a>
                </li>
                <li>
                    <a href="myCart.html"> My Cart </a>
                </li>
                <li>
                    <a href="myOrders.html"> My Orders </a>
                </li>
                <li>
                    <a href="addresses.html"> Addresses </a>
                </li>
                <li>
                    <a href="signIn.html"> Log out </a>
                </li>
            </ul>
        </div>

        <div class="Profile acount_part2">
            <div class="personalDetails checkout_content">
                <div class="acount_content">
                    <h2 class="acountTitle1">Personal Details</h2>
                    <form action="" class="row g-3 form_page">
                        <div class="col-md-12">
                            <label for="inputFirstName" class="form-label"
                            >Full Name
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="inputFirstName"
                                placeholder="First Name"
                                value="Donia El Wazery"
                            />
                        </div>

                        <div class="col-md-12">
                            <label for="inputPhone " class="form-label"
                            >Phone Number
                            </label>
                            <input
                                type="tel"
                                class="form-control"
                                id="phone"
                                name="phone"
                                placeholder="Phone Number"
                                value="+201521457896"
                            />
                        </div>
                        <div class="col-md-12">
                            <label for="inputEmail" class="form-label">Email Adress </label>
                            <input
                                type="email"
                                class="form-control"
                                id="inputEmail"
                                placeholder="Email"
                                value="doniaahmedelwazery@gmail.com"
                            />
                        </div>
                        <div class="col-md-12">
                            <a href="changePassword.html">Change Password</a>
                        </div>
                    </form>
                    <input type="submit" value="Save" class="btn_page "/>

                </div>
            </div>
        </div>
    </section>

@endsection
@pushonce('scripts')
    <script>
        const phoneInputField = document.querySelector("#phone");

        function getIp(callback) {
            fetch('https://ipinfo.io/41.47.128.120?token=6f23784d8e0441', {headers: {'Accept': 'application/json'}})
                .then((resp) => resp.json())
                .catch(() => {
                    return {
                        country: "eg",
                    };
                })
                .then((resp) => callback(resp.country));
        }

        const phoneInput = window.intlTelInput(phoneInputField, {
            initialCountry: "auto",
            geoIpLookup: getIp,
            utilsScript:
                "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
    </script>
@endpushonce

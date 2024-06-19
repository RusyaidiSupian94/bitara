@extends('layouts/blankLayout')

@section('title', 'Register')

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection


@section('content')
    <div class="position-relative">
        <div class="authentication-basic container-p-y">
            <div class="authentication-inner py-4">

                <div class="card w-75 p-2 mx-auto ">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center mt-5">
                        <a href="{{ url('/') }}" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">@include('_partials.macros', ['height' => 20])</span>
                            <span class="app-brand-text demo text-heading fw-semibold">BITARA MART</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <div class="card-body mt-2">

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form id="registrationForm" class="mb-3" action="{{ route('save-updated-profile') }}"
                            method="POST">
                            <!-- @csrf token need to put every post -->
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-3">
                                    <img src="{{ asset('assets/img/avatars/1.png') }}" alt="">
                                </div>
                                <div class="col-12 col-md-9">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-floating form-floating-sm form-floating-outline mb-3">
                                                <input type="text" class="form-control form-control-sm" id="fname"
                                                    name="fname" placeholder="Enter your first name"
                                                    value="{{ $user->user_details->fname ?? '' }}" autofocus required>
                                                <label for="fname">First Name <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-floating form-floating-outline mb-3">
                                                <input type="text" class="form-control form-control-sm" id="lname"
                                                    name="lname" placeholder="Enter your last name"
                                                    value="{{ $user->user_details->lname ?? '' }}" autofocus required>
                                                <label for="lname">Last Name <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-floating form-floating-outline mb-3">
                                                <input type="text" class="form-control form-control-sm" id="address_1"
                                                    name="address_1" placeholder="Enter your address"
                                                    value="{{ $user->user_details->address_1 ?? '' }}" autofocus required>
                                                <label for="address_1">Address 1 <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-floating form-floating-outline mb-3">
                                                <input type="text" class="form-control form-control-sm" id="address_2"
                                                    name="address_2" placeholder="Enter your address"
                                                    value="{{ $user->user_details->address_2 ?? '' }}" autofocus>
                                                <label for="address_2">Address 2</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">

                                            <div class="form-floating form-floating-outline mb-3">
                                                <input type="number" class="form-control" id="contact_no" name="contact_no"
                                                       placeholder="Enter your phone number" autofocus value="{{ $user->user_details->contact_no ?? ''}}"
                                                       pattern="[0-9]*" inputmode="numeric" required>
                                                <label for="contact_no">Contact No.<span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-floating form-floating-outline mb-3">
                                                <div class="form-floating form-floating-outline">
                                                    <select onchange="onChangePostcode(this)" id="postcode" name="postcode" class="form-select" required>
                                                        @foreach ($postcodes as $pcode)
                                                        <option value="{{ $pcode->id }}" {{ $pcode->id == ($user->user_details->postcode ?? '') ? 'selected' : '' }}>
                                                            {{ $pcode->postcode }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <label for="postcode">Postcode<span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-floating form-floating-outline mb-3">
                                                <div class="form-floating form-floating-outline">
                                                    <select id="district" name="district" class="form-select" required>
                                                        @foreach ($districts as $district)
                                                        <option value="{{ $district->id }}" {{ $district->id == ($user->user_details->district_id ?? '') ? 'selected' : '' }}>
                                                            {{ $district->district_name }}
                                                        </option>
                                                    @endforeach
                                                    </select>
                                                    <label for="district">District<span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-floating form-floating-outline mb-3">
                                                <div class="form-floating form-floating-outline">
                                                    <select id="state" name="state" class="form-select" required>
                                                        @foreach ($states as $state)
                                                        <option value="{{ $state->id }}" {{ $state->id == ($user->user_details->state_id ?? '') ? 'selected' : '' }}>
                                                            {{ $state->state_name }}
                                                        </option>
                                                    @endforeach
                                                    </select>
                                                    <label for="state">State<span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                    {{-- <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-floating form-floating-outline mb-3">
                                                <input type="text" class="form-control form-control-sm" id="postcode"
                                                    name="postcode"
                                                    placeholder="Enter your postcode"value="{{ $user->user_details->postcode }}"
                                                    autofocus required>
                                                <label for="postcode">Postcode<span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-floating form-floating-outline mb-3">
                                                <div class="form-floating form-floating-outline">
                                                    <select id="state" name="state" class="form-select" required>
                                                        @foreach ($states as $state)
                                                            <option value="{{ $state->id }}"
                                                                {{ $state->id == $user->user_details->state_id ? 'selected' : '' }}>
                                                                {{ $state->state_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <label for="state">State<span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3 form-password-toggle">
                                                <div class="input-group input-group-merge">
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="password" id="old_password" class="form-control"
                                                            name="old_password"
                                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                            aria-describedby="old_password" />
                                                        <label for="old_password">Old Password</label>
                                                    </div>
                                                    <span class="input-group-text cursor-pointer"><i
                                                            class="mdi mdi-eye-off-outline"></i></span>
                                                    @error('old_password')
                                                        <div class="alert alert-danger">Incorrect password.
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3 form-password-toggle">
                                                <div class="input-group input-group-merge">
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="password" id="password" class="form-control"
                                                            name="password"
                                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                            aria-describedby="password" />
                                                        <label for="password">Password</label>
                                                    </div>
                                                    <span class="input-group-text cursor-pointer"><i
                                                            class="mdi mdi-eye-off-outline"></i></span>
                                                    @error('password')
                                                        <div class="alert alert-danger">Password must be more than 5 digits.
                                                        </div>
                                                    @enderror
                                                </div>
                                                {{-- <small><i>Password must be more than 5 digits.</i> </small> --}}
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3 form-password-toggle">
                                                <div class="input-group input-group-merge">
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="password" id="confirm_password" class="form-control"
                                                            name="confirm_password"
                                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                            aria-describedby="password" />
                                                        <label for="confirm_password">Confirm Password</label>

                                                    </div>
                                                    <span class="input-group-text cursor-pointer"><i
                                                            class="mdi mdi-eye-off-outline"></i></span>
                                                    @error('confirm_password')
                                                        <div class="alert alert-danger">Password
                                                            did not match</div>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <hr>

                                    <div class="row justify-content-end">
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary d-grid w-100">
                                                Save
                                            </button>
                                        </div>

                                        <div class="col-md-2">

                                            @if($user->role->role_id == 3)
                                            <a href="{{ route('dashboard-customer') }}" class="btn btn-warning d-grid w-100">
                                                Back
                                            </a>
                                        @else
                                            <a href="{{ route('dashboard-analytics') }}" class="btn btn-warning d-grid w-100">
                                                Back
                                            </a>
                                        @endif
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            // $('#confirm_password').on('input', function() {
            //     var password = $('#password').val();
            //     var confirmPassword = $('#confirm_password').val();

            //     // Check if passwords match
            //     if (password != confirmPassword) {
            //         $('#match').show();
            //         event.preventDefault();
            //     } else {
            //         $('#match').hide();
            //     }

            // });

            // $('#password').on('input', function() {
            //     var password = $('#password').val();

            //     if (password.length > 0 && password.length < 5) {

            //         $('#password_length').show();
            //         event.preventDefault();
            //     } else {
            //         $('#password_length').hide();
            //     }
            // })
        });
        function onChangePostcode(e) {
            var selectedPostcode = e.value;
            var stateDropdown = $('#state');
                var districtDropdown = $('#district');
            $.ajax({
                url: "{{route('get-poscode-details')}}", // Replace with your actual endpoint
                type: 'GET',
                data: { postcode: selectedPostcode },
                success: function(response) {

                    console.log(response);
                        stateDropdown.empty().append('<option selected disabled>Please Choose</option>');
                        districtDropdown.empty().append('<option selected disabled>Please Choose</option>');

                            stateDropdown.append('<option selected value="' + response.state.id + '">' + response.state.state_name + '</option>');
            
                            districtDropdown.append('<option selected value="' + response.district.id + '">' + response.district.district_name + '</option>');

                },
                error: function(xhr, status, error) {
                    console.error("Error fetching state and district data:", error);
                }
            });
        }
    </script>
@endsection

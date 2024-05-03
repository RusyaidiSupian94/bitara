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

                <!-- Register Card -->
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
                        <h4 class="mb-2">Start your adventurous with us🚀</h4>

                        <form id="registrationForm" class="mb-3" action="{{ route('auth-register-customer') }}"
                            method="POST">
                            <!-- @csrf token need to put every post -->
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline mb-3">
                                        <input type="text" class="form-control" id="fname" name="fname"
                                            placeholder="Enter your first name" autofocus required
                                            value="{{ old('fname') }}">
                                        <label for="fname">First Name <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-3">
                                        <input type="text" class="form-control" id="lname" name="lname"
                                            placeholder="Enter your last name" autofocus required
                                            value="{{ old('lname') }}">
                                        <label for="lname">Last Name <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-3">
                                        <input type="text" class="form-control" id="address_1" name="address_1"
                                            placeholder="Enter your address" autofocus required
                                            value="{{ old('address_1') }}">
                                        <label for="address_1">Address 1 <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-3">
                                        <input type="text" class="form-control" id="address_2" name="address_2"
                                            placeholder="Enter your address" autofocus value="{{ old('address_2') }}">
                                        <label for="address_2">Address 2</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form-floating form-floating-outline mb-3">
                                                <input type="text" class="form-control" id="postcode" name="postcode"
                                                    placeholder="Enter your postcode" autofocus required
                                                    value="{{ old('postcode') }}">
                                                <label for="postcode">Postcode<span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-floating form-floating-outline mb-3">
                                                <div class="form-floating form-floating-outline">
                                                    <select id="state" name="state" class="form-select" required>
                                                        <option selected disabled>Please Choose</option>
                                                        @foreach ($states as $state)
                                                            <option @selected(old('state') == $state->id)
                                                                value="{{ $state->id }}">{{ $state->state_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <label for="state">State<span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline mb-3">
                                        <input type="text" class="form-control" id="username" name="username"
                                            placeholder="Enter your username" autofocus required
                                            value="{{ old('username') }}">
                                        <label for="username">Username<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-3">
                                        <input type="text" class="form-control" id="email" name="email"
                                            placeholder="Enter your email" required value="{{ old('email') }}">
                                        <label for="email">Email<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="mb-3 form-password-toggle">
                                        <div class="input-group input-group-merge">
                                            <div class="form-floating form-floating-outline">
                                                <input type="password" id="password"
                                                    class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                                    name="password"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="password" required value="{{ old('password') }}" />
                                                <label for="password">Password<span class="text-danger">*</span></label>
                                            </div>
                                            <span class="input-group-text cursor-pointer"><i
                                                    class="mdi mdi-eye-off-outline"></i></span>

                                        </div>
                                        @if ($errors->has('password'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @endif

                                    </div>

                                    <!-- Confirm Password field -->
                                    <div class="mb-3 form-password-toggle">
                                        <div class="input-group input-group-merge">
                                            <div class="form-floating form-floating-outline">
                                                <input type="password" id="confirm_password" class="form-control"
                                                    name="confirm_password"
                                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                    aria-describedby="password" required
                                                    value="{{ old('confirm_password') }}" />
                                                <label for="confirm_password">Confirm Password<span
                                                        class="text-danger">*</span></label>
                                            </div>
                                            <span class="input-group-text cursor-pointer"><i
                                                    class="mdi mdi-eye-off-outline"></i></span>

                                        </div> <span id="match" class="text-danger" style="display: none;">Password
                                            did not match</span>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="terms-conditions"
                                                name="terms" @checked(old('terms')) required>
                                            <label class="form-check-label" for="terms-conditions">
                                                I agree to
                                                <a href="javascript:void(0);">privacy policy & terms</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <button type="submit" class="btn btn-primary d-grid w-50 mx-auto">
                                REGISTER
                            </button>


                        </form>

                        <p class="text-center">
                            <span>Already have an account?</span>
                            <a href="{{ url('auth/login-basic') }}">
                                <span>Sign in instead</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- Register Card -->
                <img src="{{ asset('assets/img/illustrations/tree-3.png') }}" alt="auth-tree"
                    class="authentication-image-object-left d-none d-lg-block">
                <img src="{{ asset('assets/img/illustrations/auth-basic-mask-light.png') }}"
                    class="authentication-image d-none d-lg-block" alt="triangle-bg">
                <img src="{{ asset('assets/img/illustrations/tree.png') }}" alt="auth-tree"
                    class="authentication-image-object-right d-none d-lg-block">
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#confirm_password').on('input', function() {
                var password = $('#password').val();
                var confirmPassword = $('#confirm_password').val();

                // Check if passwords match
                if (password != confirmPassword) {
                    $('#match').show();
                } else {
                    $('#match').hide();
                }
            });

            $('#password').keyup(function(e) {
                var password = $('#password').val();
                var confirmPassword = $('#confirm_password').val();
                if (password.length < 5) {
                    $('#match').text('Password must be more than 5 digit');
                    $('#match').show();
                } else if (password != confirmPassword) {
                    $('#match').text('Password does not match');
                    $('#match').show();
                } else {
                    $('#match').hide();
                }
            });

            $("#registrationForm").on("submit", function(event) {
                var password = $('#password').val();
                console.log(password);
                var confirmPassword = $('#confirm_password').val();
                if (password > 0) {
                    if (password.length < 5) {
                        $('#match').text('Password must be more than 5 digit');
                        $('#match').show();
                        event.preventDefault();
                    } else if (confirmPassword.length > 0 && password != confirmPassword) {
                        $('#match').text('Password does not match');
                        $('#match').show();
                        event.preventDefault();
                    } else {
                        $('#match').hide();

                        return true;
                    }
                } else {

                    return true;
                }
            });
        });
    </script>
@endsection

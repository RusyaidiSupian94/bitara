@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Staff')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card w-100 h-100">
                <h4 class="p-3 mb-4"><span class="text-muted fw-light">Staff /</span> Edit
                </h4>

                <div class="card m-3">

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

                    <div class="card-body">
                        <form id="staffForm" class="mb-3" action="{{ route('save-edited-staff', ['id' => $user->id]) }}"
                            method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline mb-3">
                                        <input type="text" class="form-control" id="username" name="username"
                                            placeholder="Enter your username" autofocus required
                                            value="{{ $user->username }}">
                                        <label for="username">Username<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline mb-3">
                                        <input type="text" class="form-control" id="email" name="email"
                                            placeholder="Enter your email" required value="{{ $user->email }}">
                                        <label for="email">Email<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-floating form-floating-outline mb-3">
                                        <div class="form-floating form-floating-outline">
                                            <select id="role" name="role" class="form-select" required>
                                                <option value="2" @if ($user->role->role_id == 2) selected @endif>
                                                    Staff </option>
                                                <option value="1" @if ($user->role->role_id == 1) selected @endif>
                                                    Admin </option>
                                            </select>
                                            <label for="role">Role<span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3 form-password-toggle">
                                            <div class="input-group input-group-merge">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="password" id="password"
                                                        class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                                        name="password"
                                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                        aria-describedby="password" value="{{ old('password') }}" />
                                                    <label for="password">Password</label>
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
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3 form-password-toggle">
                                            <div class="input-group input-group-merge">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="password" id="confirm_password" class="form-control"
                                                        name="confirm_password"
                                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                        aria-describedby="password" value="{{ old('confirm_password') }}" />
                                                    <label for="confirm_password">Confirm Password</label>
                                                </div>
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="mdi mdi-eye-off-outline"></i></span>

                                            </div> <span id="match" class="text-danger" style="display: none;">Password
                                                did not match</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary d-grid w-50 mx-auto">
                                Update
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- Include SweetAlert CSS -->

<!-- Include SweetAlert JavaScript -->

@section('page-style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.4/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection
@section('page-script')
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.4/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#confirm_password').on('input', function() {
                var password = $('#password').val();
                var confirmPassword = $('#confirm_password').val();

                // Check if passwords match
                if (confirmPassword.length > 0 && password != confirmPassword) {
                    $('#match').text('Password does not match');
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
                } else if (confirmPassword.length > 0 && password != confirmPassword) {
                    $('#match').text('Password does not match');
                    $('#match').show();
                } else {
                    $('#match').hide();
                }
            });

            $("#staffForm").on("submit", function(event) {
                var password = $('#password').val();
                console.log(password);
                var confirmPassword = $('#confirm_password').val();
                if (password >0) {
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


        function deleteProduct(id) {
            Swal.fire({
                title: 'Confirm to remove the selected staff?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('delete-staff') }}",
                        data: {
                            '_token': '{{ csrf_token() }}',
                            staff_id: id
                        },
                        success: function(response) {

                            location.reload();

                        },
                        error: function(xhr, status, error) {
                            Swal.fire(error, '', 'error');
                        }
                    });
                }
            });
        }
    </script>
@endsection

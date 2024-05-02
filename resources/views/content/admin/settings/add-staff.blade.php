@extends('layouts/contentNavbarLayout')

@section('title', 'Products')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card w-100 h-100">
                <h4 class="p-3 mb-4"><span class="text-muted fw-light">Staff /</span> Add
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
                        <form id="staffForm" class="mb-3" action="{{ route('save-staff') }}"
                            method="POST">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="form-floating form-floating-outline mb-3">
                                    <input type="text" class="form-control" id="username" name="username"
                                        placeholder="Enter your username" autofocus required value="{{ old('username') }}">
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
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary d-grid w-50 mx-auto">
                            Add
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
            $('#staffTbl').DataTable();
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

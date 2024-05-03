@extends('layouts/contentNavbarLayout')

@section('title', 'Staff')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card w-100 h-100">
                <h4 class="p-3 mb-4"><span class="text-muted fw-light">Staff /</span> Dashboard
                </h4>

                <div class="card m-3">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5>List of staff</h5>
                            </div>
                            <div class="col-6">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('add-staff') }}">
                                        <button type="button" class="btn btn-sm btn-primary"><i class="mdi mdi-plus"></i>
                                            Add New Staff</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

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
                    <div class="p-2">

                        <div class="table-responsive">
                            <table id="staffTbl" class="table table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->email }}</td>
                                            @if ($user->role->role_id == 1)
                                                <td>Admin</td>
                                            @else
                                                <td>Staff</td>
                                            @endif
                                            <td>
                                                <div>
                                                    <a href="{{ route('edit-staff', ['id' => $user->id]) }}"
                                                        class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit"><i
                                                        class="mdi mdi-pencil-outline"></i></a>
                                                        @if($user->id != 1)
                                                            
                                                            <a onclick="deletestaff({{ $user->id }});"
                                                            class="btn
                                                            btn-sm btn-text-danger rounded-pill btn-icon item-delete"><i
                                                                class="mdi mdi-trash-can-outline text-danger"></i></a>
                                                        @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
            // $('#staffTbl').DataTable();
        });


        function deletestaff(id) {
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

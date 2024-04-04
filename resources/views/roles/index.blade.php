@extends('layouts.app')

@section('content')
    @include('layouts.header')
    @include('layouts.sidebar')
    
    <!-- Main Content -->
    @if ($message = Session::get('success'))
                <script>
                    Swal.fire({
                        position: 'center-center',
                        icon: 'success',
                        title: 'SUCCESS',
                        text:"{{ session('success') }}",
                        showConfirmButton: true,
                    })
                </script>
            @endif
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="d-flex align-items-center justify-content-between"> <!-- Added justify-content-between class -->
                            <h4 class="mb-sm-0 font-size-14 flex-grow-1">Manage Roles</h4>
                            <div class="flex-shrink-0 d-flex"> <!-- Wrapped buttons in a flex container -->
                                @can('create-role')
                                <a href="{{ route('roles.create') }}" class="btn btn-info btn-sm my-2"><i class="bx bx-plus-circle"></i> Add New Role</a>
                                @endcan

                                <form id="deleteRoleForm" action="{{ route('deleteRoles') }}" method="post">
                                @csrf
                                @method('DELETE')
                                    <input type="hidden" name="role_ids" id="selectedRoleIdsInput">
                                    <button type="button" id="deleteButton" class="btn btn-danger btn-sm my-2 mx-1   mdi mdi-delete" onclick="deleteSelected()"></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 20px;">
                                            <div class="form-check font-size-16 align-middle">
                                                <input class="form-check-input" type="checkbox" id="transactionCheck01" onclick="checkOtherBox()">
                                                <label class="form-check-label" for="transactionCheck01"></label>
                                            </div>
                                        </th>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Permissions</th>
                                        <th scope="col" style="width: 250px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $role)
                                    <tr>
                                        <td>
                                            <div class="form-check font-size-16">
                                                <input class="form-check-input" type="checkbox" id="transactionCheck{{ $role->id }}">
                                                <label class="form-check-label" for="transactionCheck{{ $role->id }}"></label>
                                            </div>
                                        </td>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td class="editable">{{ $role->name }}</td>
                                        <td>
                                            @if ($role->name=='Super Admin')
                                                <span class="badge bg-primary w-auto">All</span>
                                            @else
                                                @forelse ($role->getAllPermissions()->pluck('name') as $permission)
                                                    <span class="badge bg-primary w-auto me-2">{{ $permission }}</span>
                                                @empty
                                                @endforelse
                                            @endif
                                        </td>
                                        <td>
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <a href="{{ route('roles.show', $role->id) }}" class="btn btn-warning btn-sm"><i class="mdi mdi-eye"></i></a>

                                            @if ($role->name != 'Super Admin')
                                                @can('edit-role')
                                                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm"><i class="mdi mdi-pencil"></i></a>
                                                @endcan

                                                @can('delete-role')
                                                    @if ($role->name != Auth::user()->hasRole($role->name))
                                                        <button type="button" class="btn btn-danger btn-sm delete-role" data-role-id="{{ $role->id }}" data-url="{{ route('roles.destroy', $role->id) }}">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button>
                                                    @endif
                                                @endcan
                                            @endif
                                        </form>
                                        </td>
                                    </tr>
                                    @empty
                                        <td colspan="3">
                                            <span class="text-danger">
                                                <strong>No Role Found!</strong>
                                            </span>
                                        </td>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $roles->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function checkOtherBox() {
        var otherCheckBoxes = document.querySelectorAll('.form-check-input');
        for (var i = 0; i < otherCheckBoxes.length; i++) {
            otherCheckBoxes[i].checked = document.getElementById('transactionCheck01').checked;
        }
    }

    document.getElementById('transactionCheck01').addEventListener('click', checkOtherBox);

    function collectSelectedRoleIds() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            selectedRoleIds = [];

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    var closestTr = checkboxes[i].closest('tr');

                    // Check if closestTr is not null and has the expected structure
                    if (closestTr && closestTr.querySelector('.delete-role')) {
                        var roleId = closestTr.querySelector('.delete-role').getAttribute('data-role-id');
                        selectedRoleIds.push(roleId);
                    }
                }
            }
            return selectedRoleIds;
        }


        function deleteSelected() {
            var selectedRoleIds = collectSelectedRoleIds();
            console.log(selectedRoleIds.length);

            if (selectedRoleIds.length > 0) {
                console.log(selectedRoleIds);
                document.getElementById('selectedRoleIdsInput').value = selectedRoleIds.join(',');
                Swal.fire({
                        title: 'Are you sure you want to permanently delete these roles?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit the form when confirmed
                            document.getElementById('deleteRoleForm').submit();
                        }
                    });
            } else {
                alert('No tickets selected!');
            }
        }

    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-role');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                Swal.fire({
                    title: "Do you want to delete it?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If user confirms, submit the form
                        const form = button.closest('form');
                        form.submit();
                        Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 2000
                        });
                    }
                });
            });
        });
    });
</script>
@endsection
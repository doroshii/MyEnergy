@extends('layouts.app')

@section('content')
    @include('layouts.header')
    @include('layouts.sidebar')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="card">
                    <div class="card-header border-bottom">
                        <div class="d-flex align-items-center justify-content-between"> <!-- Added justify-content-between class -->
                            <h4 class="mb-sm-0 font-size-14 flex-grow-1">Manage Users</h4>
                            <div class="flex-shrink-0 d-flex"> <!-- Wrapped buttons in a flex container -->
                                @can('create-user')
                                    <a href="{{ route('users.create') }}" class="btn btn-info btn-sm my-2"><i class="mdi mdi-plus-circle"></i> Add New User</a>
                                @endcan
                                <form id="deleteUserForm" action="{{ route('destroyMultiple') }}" method="post">
                                @csrf
                                @method('DELETE')
                                    <input type="hidden" name="user_ids" id="selectedUserIdsInput">
                                    <button type="button" id="deleteButton" class="btn btn-danger btn-sm my-2 mx-1 mdi mdi-delete" title = "Delete Selected"onclick="deleteSelected()"></button>
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
                                        <th scope="col">Email</th>
                                        <th scope="col">Roles</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)

                                    <tr>
                                    <td>
                                        <div class="form-check font-size-16">
                                            <input class="form-check-input userCheckbox" type="checkbox" name="ids[]" value="{{ $user->id }}" id="transactionCheck{{ $user->id }}">
                                            <label class="form-check-label" for="transactionCheck{{ $user->id }}"></label>
                                        </div>
                                    </td>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $user->name }}
                                        {{-- <label id="label_name-{{ $user->id }}">{{ $user->name }}</label>
                                        <input type="text" class="form-control" id="name-{{ $user->id }}" value="{{ $user->name }}" hidden> --}}
                                        </td>
                                        <td>{{ $user->email }}
                                        {{-- <label id="label_email-{{ $user->id }}">{{ $user->email }}</label>
                                        <input type="text" class="form-control" id="email-{{ $user->id }}" value="{{ $user->email }}" hidden> --}}
                                        </td>
                                        {{-- <td id="label_role-{{ $user->id }}">
                                            @foreach ($user->getRoleNames() as $role)
                                                <span class="badge bg-primary">{{ $role }}</span>
                                            @endforeach
                                        </td>
                                        <td id="role-{{ $user->id }}" hidden>
                                            <select>
                                                @foreach ($user->getRoleNames() as $role)
                                                    <option value="{{ $role }}">{{ $role }}</option>
                                                @endforeach
                                            </select>
                                        </td> --}}
                                        <td>
                                            @forelse ($user->getRoleNames() as $role)
                                                <span class="badge bg-primary">{{ $role }}</span>
                                            @empty
                                            @endforelse
                                        </td>
                                        <td>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-warning btn-sm" id="show-{{ $user->id }}" data-toggle="tooltip" title="View Details"><i class="mdi mdi-eye"></i></a>

                                                @if (in_array('Super Admin', $user->getRoleNames()->toArray() ?? []) )
                                                    @if (Auth::user()->hasRole('Super Admin'))
                                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="mdi mdi-pencil"></i></a>
                                                    @endif
                                                @else
                                                    @can('edit-user')
                                                        {{-- <a onclick="edit_details({{ $user->id }})" class="btn btn-primary btn-sm" id="edit-{{ $user->id }}"><i class="mdi mdi-pencil-square"></i> Edit</a> --}}

                                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="mdi mdi-pencil" data-toggle="tooltip" title="Edit User"></i></a>
                                                    @endcan

                                                    {{-- @can('save-user')
                                                        <a onclick="save_details({{ $user->id }})" class="btn btn-primary btn-sm" id="save-{{ $user->id }}" hidden><i class="mdi mdi-edit"></i> Save</a>

                                                        {{-- <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="mdi mdi-pencil-square"></i> Edit</a>
                                                    @endcan --}}


                                                    {{-- @can('cancel-user')
                                                        <a onclick="cancel_details({{ $user->id }})" class="btn btn-danger btn-sm" id="cancel-{{ $user->id }}" hidden><i class="mdi mdi-edit"></i> Cancel</a>

                                                        {{-- <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="mdi mdi-pencil-square"></i> Edit</a>
                                                    @endcan --}}


                                                    @can('delete-user')
                                                        @if (Auth::user()->id!=$user->id)
                                                        <button type="button" class="btn btn-danger btn-sm delete-user" data-user-id="{{ $user->id }}" data-url="{{ route('users.destroy', $user->id) }}">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button>
                                                        @endif
                                                    @endcan
                                                @endif

                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                        <td colspan="5">
                                            <span class="text-danger">
                                                <strong>No User Found!</strong>
                                            </span>
                                        </td>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    function checkOtherBox() {
        var otherCheckBoxes = document.querySelectorAll('input[type="checkbox"]');
        for (var i = 0; i < otherCheckBoxes.length; i++) {
            otherCheckBoxes[i].checked = document.getElementById('transactionCheck01').checked;
        }
    }

    document.getElementById('transactionCheck01').addEventListener('click', checkOtherBox);

    function collectSelectedUserIds() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            selectedUserIds = [];

            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    var closestTr = checkboxes[i].closest('tr');

                    // Check if closestTr is not null and has the expected structure
                    if (closestTr && closestTr.querySelector('.delete-user')) {
                        var roleId = closestTr.querySelector('.delete-user').getAttribute('data-user-id');
                        selectedUserIds.push(roleId);
                    }
                }
            }
            return selectedUserIds;
        }


        function deleteSelected() {
            var selectedUserIds = collectSelectedUserIds();
            console.log(selectedUserIds.length);

            if (selectedUserIds.length > 0) {
                console.log(selectedUserIds);
                document.getElementById('selectedUserIdsInput').value = selectedUserIds.join(',');
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
                            document.getElementById('deleteUserForm').submit();
                        }
                    });
            } else {
                alert('No tickets selected!');
            }
        }

    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-user');

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
                        icon: "success",
                        title: "User has been deleted",
                        showConfirmButton: false,
                        timer: 1500
                        });
                    }
                });
            });
        });
    });
</script>
@endsection
<!-- user/create.blade.php backup -->
@extends('layouts.app')

@section('content')
    @include('layouts.header')
    @include('layouts.sidebar')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="card">
                    <div class="card-header">
                        <div class="float-start">
                            <h4 class="mb-sm-0 font-size-14">Add New User</h4>
                        </div>
                        <div class="float-end">
                            <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.store') }}" method="post">
                            @csrf

                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                                <div class="col-md-6">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
                                <div class="col-md-6">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                                <div class="col-md-6">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start">Confirm Password</label>
                                <div class="col-md-6">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="roles" class="col-md-4 col-form-label text-md-end text-start">Roles</label>

                                <div class="col-md-6">
                                    <select class="form-select @error('roles') is-invalid @enderror" aria-label="Roles" id="roles" name="roles[]">
                                        @forelse ($roles as $role)

                                            @if ($role!='Super Admin')
                                                <option value="{{ $role }}" {{ in_array($role, old('roles') ?? []) ? 'selected' : '' }}>
                                                {{ $role }}
                                                </option>
                                            @else
                                                @if (Auth::user()->hasRole('Super Admin'))
                                                    <option value="{{ $role }}" {{ in_array($role, old('roles') ?? []) ? 'selected' : '' }}>
                                                    {{ $role }}
                                                    </option>
                                                @endif
                                            @endif

                                        @empty

                                        @endforelse
                                    </select>
                                    @if ($errors->has('roles'))
                                        <span class="text-danger">{{ $errors->first('roles') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <input type="submit" class="col-md-3 offset-md-5 btn btn-primary btn-sm create-user" data-url="{{ route('users.index') }}" value="Add User">
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const createButtons = document.querySelectorAll('.create-user');

                                    createButtons.forEach(button => {
                                        button.addEventListener('click', function () {
                                            Swal.fire({
                                                icon: "success",
                                                title: "Success",
                                                text: "User has been created",
                                                showConfirmButton: false,
                                                timer: 1500
                                            }).then(() => {
                                                // After showing the success message, you may redirect the user or perform other actions
                                                // For example, you might redirect the user to the index page
                                                window.location.href = "{{ route('users.index') }}";
                                            });
                                        });
                                    });
                                });
                            </script>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div id="layout-wrapper">

    @include('layouts.header')
    @include('layouts.sidebar')
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Buildings List</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route ('buildings.index') }}">Buildings</a></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="w-100">
                            <div class="card">
                                <div class="card-body">
                                    <div>
                                        <div class="row">
                                            @foreach($buildings as $building)
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card shadow-none border">
                                                        <div class="card-body p-3">
                                                            <div>
                                                                <div class="float-end ms-2">
                                                                    <div class="dropdown mb-2">
                                                                        <a class="font-size-16 text-muted" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                                            <i class="mdi mdi-dots-horizontal"></i>
                                                                        </a>
                                                                        
                                                                        <div class="dropdown-menu dropdown-menu-end">                                                         
                                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editBuildingModal{{ $building->id }}">Edit</a>                                                                   
                                                                            <div class="dropdown-divider"></div>               
                                                                            <form action="{{ route('buildings.destroy', $building->id) }}" method="POST" id="deleteForm{{$building->id}}">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="button" class="dropdown-item text-danger delete-building-btn" data-building-id="{{ $building->id }}">Remove</button>
                                                                            </form>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="avatar-xs me-3 mb-3">
                                                                    <div class="avatar-title bg-transparent rounded">
                                                                        <i class="bx bxs-folder font-size-24 text-warning"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex">
                                                                    <div class="overflow-hidden me-auto">               
                                                                        <h5 class="font-size-14 text-truncate mb-1"><a href="{{ route('floors.index', ['building_id' => $building->id]) }}" class="text-body">{{ $building->building_name }}</a></h5>


                                                                        <p class="text-muted text-truncate mb-0">{{ $building->num_of_floors }} Floors</p>
                                                                    </div>
                                                                    <div class="align-self-end ms-2">
                                                                        <!-- Display total energy consumption for the room -->
                                                                        <p class="text-muted mb-0">{{ number_format($building->totalEnergy(), 2) }} kWh</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <div class="col-xl-4 col-sm-6">
                                                <div class="card shadow-none border" id="building">
                                                    <div class="card-body p-3 d-flex align-items-center justify-content-center">
                                                        <a class="addBldg" role="button" aria-haspopup="true" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Building">
                                                            <i class="bx bx-plus-medical"></i>
                                                        </a>                                               
                                                    </div>                                        
                                                </div>
                                            </div>
                                            <!-- end col -->

                                        </div>
                                        <!-- end row -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>            
                    <!--  end row -->
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
        </div>
        <!-- end main content-->
    </div>
    <!-- end layout-wrapper -->

 <!-- add building -->
    <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Building</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addBuildingForm" action="{{ route('buildings.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row mb-3">
                                <label for="bldgName" class="col-sm-2 col-form-label">Building Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="bldgName" name="building_name">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="numOfFloors" class="col-sm-2 col-form-label">Number of Floors:</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="numOfFloors" name="num_of_floors">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Building</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="successMessage" class="alert alert-success" role="alert" style="display: none;"></div>

<!-- edit building -->
@isset($building)
<div class="modal fade bs-example-modal-center" id="editBuildingModal{{ $building->id }}" tabindex="-1" aria-labelledby="editBuildingModal{{ $building->id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBuildingModal{{ $building->id }}Label">Edit Building</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('buildings.update', $building->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editBuildingName" class="form-label">Building Name</label>
                        <input type="text" class="form-control" id="editBuildingName" name="building_name" value="{{ $building->building_name }}">
                    </div>
                    <div class="mb-3">
                        <label for="editNumOfFloors" class="form-label">Number of Floors</label>
                        <input type="number" class="form-control" id="editNumOfFloors" name="num_of_floors" value="{{ $building->num_of_floors }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endisset

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get all input fields in the form
        const inputs = document.querySelectorAll('.form-control');

        // Add focus event listener to each input field
        inputs.forEach(input => {
            input.addEventListener('focus', function () {
                // Change the border color when the input field is focused
                this.style.borderColor = '#007bff'; // Change to your desired border color
            });

            // Remove the border color when the input field loses focus
            input.addEventListener('blur', function () {
                this.style.borderColor = ''; // Reset to default border color
            });
        });
    });

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    document.addEventListener('DOMContentLoaded', function () {
        // Handle click event on delete button
        $('.delete-building-btn').on('click', function () {
            var buildingId = $(this).data('building-id');
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms deletion, submit the form
                    $('#deleteForm'+buildingId).submit();
                }
            });
        });
    });

    $(document).ready(function() {
        $('#addBuildingForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    $('#addBuildingForm')[0].reset();
                    $('.bs-example-modal-center').modal('hide');
                    $('#successMessage').text(response.success).show();
                    // You may need to reload the building list here
                },
                error: function(error) {
                    console.log(error);
                    // Handle errors here
                }
            });
        });
    });

    $(document).ready(function() {
        $('#editBuildingForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    $('#editBuildingModal').modal('hide');
                    // Display SweetAlert for success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.success,
                    });
                    // You may need to reload the building list here
                },
                error: function(error) {
                    console.log(error);
                    // Handle errors here
                }
            });
        });
    });
</script>
@endsection
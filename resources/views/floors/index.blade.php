@extends('layouts.app')

@section('content')
    @include('layouts.header')
    @include('layouts.sidebar')
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Floors of {{ $building->building_name}}</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route ('buildings.index') }}">Buildings</a></li>
                                        <li class="breadcrumb-item active"><a href="">{{ $building->building_name}}</a></li>
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
                                    <!-- <div>
                                        <div class="row mb-3">
                                            <div class="col-xl-3 col-sm-6">
                                                <div class="mt-2">
                                                    <h5>Buildings List</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div>
                                        <div class="row">
                                            @forelse ($floors as $floor)
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="card shadow-none border">
                                                        <div class="card-body p-3">
                                                            <div class="col-xl-4">
                                                                <div class="card">
                                                                    <div class="card-body">
                                                                        <h5 class="card-title">{{ $floor->name }}</h5>                             
                                                                        <a href="{{ route('rooms.index') }}?floor_id={{ $floor->id }}" class="btn btn-primary">View Rooms</a>
                                                                        <p class="text-muted mb-0">{{ number_format($floor->totalEnergy(), 2) }} kWh</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                            @endforelse

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
            </div> <!-- end page-content -->
        </div> <!-- end main content-->
    </div> <!-- end layout-wrapper -->
@endsection

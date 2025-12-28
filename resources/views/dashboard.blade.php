@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                            <i class="bi bi-check-circle text-success fs-3"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1">{{ __("You're logged in!") }}</h5>
                            <p class="text-muted mb-0">Welcome to Legian Medical Clinic admin panel.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
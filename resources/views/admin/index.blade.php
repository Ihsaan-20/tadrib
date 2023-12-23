@extends('frontend.layouts.app')

@section('app')
    <h2 style="text-align:center;">Dashboard</h2>

    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="row">
        <div class="col-4">
            <div class="card text-center mb-3">
                <div class="card-body">
                    <h5 class="card-title">Coaches</h5>
                    <p class="card-text">10</p>
                    <a href="#" class="btn btn-primary">views</a>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card text-center mb-3">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>
                    <p class="card-text">10</p>
                    <a href="#" class="btn btn-primary">views</a>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card text-center mb-3">
                <div class="card-body">
                    <h5 class="card-title">Programs</h5>
                    <p class="card-text">10</p>
                    <a href="#" class="btn btn-primary">views</a>
                </div>
            </div>
        </div>

        
    </div>
@endsection

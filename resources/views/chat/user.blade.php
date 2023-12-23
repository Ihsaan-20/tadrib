@extends('frontend.layouts.app')
@section('app')

{{-- card-end --}}

<div class="card">
    <div class="row">
        <div class="col-md-4">
            all users
            <div class="user">
                <img src="" class="bg-dark" width="50" height="50" class="img-fluid" alt="">
            </div>
        </div>
        <div class="col-md-8">
            <div id="chatmessages">chat</div>
        </div>
    </div>
</div>
@endsection
@section('customJs')
    <script>
       console.log('working');
    </script>
@endsection
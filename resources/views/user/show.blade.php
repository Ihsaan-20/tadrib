@extends('frontend.layouts.app')
@section('app')
<div class="row">
    <div class="col-12">
        <strong>Profile Image:</strong>
        <br>
        @if($coach->profile_picture != null)
      <img src="{{ asset('storage/profile/'.$coach->profile_picture)}}" style='border-radius:100px' height="100px" width="100px">
@endif
      <br>
      <br>
             <div class="row">
             
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>First Name:</strong>
                        <p>{{$coach->first_name}}</p>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Last Name:</strong>
                        <p>{{$coach->last_name}}</p>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <p>{{$coach->email}}</p>
                    </div>
                </div>
        
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Phone_number:</strong>
                        <p>{{$coach->phone_number}}</p>

                    </div>
                </div>
                
              
            </div>
           
        
    </div>
</div>


@endsection
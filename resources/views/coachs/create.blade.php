@extends('frontend.layouts.app')
@section('app')
<div class="row">
    <div class="col-md-10">
        <h2 >Add New Coach</h2>
    </div>
    <div class="col-md-2 ">
        <div class="float-right">
            <a class="btn btn-primary mt-3" href="{{ url('coachs') }}"> Back</a>
        </div>
    </div>
</div>
   
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
   
<div class="row">
    <div class="col-12">
        <form action="{{ url('coachs/store') }}" method="POST">
            @csrf
          
             <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>First Name:</strong>
                        <input type="text" name="first_name" class="form-control" placeholder="First Name">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Last Name:</strong>
                        <input type="text" name="last_name" class="form-control" placeholder="Last Name">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Email:</strong>
                        <input type="email" name="email" class="form-control" placeholder="Email">
                    </div>
                </div>
        
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Phone Number:</strong>
                        <input type="text" name="phone_number" class="form-control phone_number" placeholder="Phone_number">
                    </div>
                </div>
                
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Password:</strong>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                </div>
                
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Password Confirmation:</strong>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Password Confirmation">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Tags:</strong>
                        <br>
                        @if($tags)
                        @foreach($tags as $t)
                            <input type="checkbox" name="tags[]" id="{{$t->id}}" value="{{$t->id}}">
                            <label for="option1">{{$t->tag}}</label>
                            <br>
                        @endforeach
                        @endif
                       
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Bio:</strong>
                        <input type="text" name="bio" class="form-control" placeholder="Bio">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
           
        </form>
    </div>
</div>





@endsection
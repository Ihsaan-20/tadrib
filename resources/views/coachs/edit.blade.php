@extends('frontend.layouts.app')
@section('app')
    <div class="row">
        <div class="col-md-10">
            <h2 >Update Coach</h2>
        </div>
        <div class="col-md-2 ">
            <div class="float-right">
                <a class="btn btn-primary mt-3" href="{{ route('coachs.index') }}"> Back</a>
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
  
    <form action="{{ route('coachs.update',$coach->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
   


            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>First Name:</strong>
                        <input type="text" name="first_name" value="{{ $coach->first_name }}" class="form-control" placeholder="First Name">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Last Name:</strong>
                        <input type="text" name="last_name" class="form-control" value="{{ $coach->last_name }}" placeholder="Last Name">
                    </div>
                </div>

            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Email:</strong>
                    <input type="email" name="email" value="{{ $coach->email }}" class="form-control" placeholder="Email">
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Phone Number:</strong>
                    <input type="text" name="phone_number" value="{{ $coach->phone_number }}" class="phone_number form-control" placeholder="Phone_Number">
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Profile Image:</strong>
                    <input type="file" name="profile_picture" class="form-control" placeholder="Profile">
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Bio:</strong>
                    <input type="text" name="bio" value="{{ $coach->bio }}" class="form-control" placeholder="bio">
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Tags:</strong>
                    <br>
                    @if($tags)
                            @foreach($tags as $t)
                                <input type="checkbox" name="tags[]" id="{{$t->id}}" value="{{$t->id}}" 
                                    {{ in_array($t->id, (array)old('tags', json_decode($coach->tags))) ? 'checked' : '' }}>
                                <label for="{{$t->id}}">{{$t->tag}}</label>
                                <br>
                            @endforeach
                        @endif
                   
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
   
    </form>
@endsection
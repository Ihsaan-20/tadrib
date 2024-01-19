@extends('frontend.layouts.app')
@section('app')
<div class="row">
    <div class="col-md-10">
        <h2>Edit Workout</h2>
    </div>
    <div class="col-md-2 ">
        <div class="float-right">
            <a class="btn btn-primary mt-3" href="{{ url('workout') }}"> Back</a>
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
        <form action="{{ route('workout.update', $workout->id) }}" method="POST"  enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Use the PUT method for updates -->

            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" name="name" value="{{ old('name', $workout->name) }}" class="form-control" placeholder="Workout Name">
                    </div>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3">
                    <div class="form-group">
                        <strong>Introductory video:</strong>
                        <input type="file" name="introductory_video" class="form-control">
                    </div>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3">
                    <div class="form-group"><br>
                        @if($workout->introductory_video)
                        <video width="150px" height="100px" controls>
                            <source src="{{ asset('storage/introductory_video/'.$workout->introductory_video) }}" type="video/mp4">
                        </video>
                            @else
                                <img src="{{ asset('images/not.jpg')}}" style="width:70px; height:40px" alt="User" />
                        @endif
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Bio:</strong>
                        <input type="text" name="text_bio" value="{{ old('text_bio', $workout->text_bio) }}" class="form-control" placeholder="text bio">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Estimated Duration:</strong>
                        <input type="time" name="estimated_duration_hours" value="{{ old('estimated_duration_hours', $workout->estimated_duration_hours) }}" class="form-control" placeholder="Estimated Duration">
                    </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Rest (in days):</strong>
                        <input type="number" name="rest" value="{{ old('rest', $workout->rest) }}" class="phone_number form-control" placeholder="Rest">
                    </div>
                </div>
                 <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Coach Name:</strong>
                        <select name='coach_id' class="form-control">
                            <option selected disabled>Select Coach</option>
                            @foreach ($coach as $w)
                                <option value="{{ $w->id }}" @if ($workout->coach_id == $w->id) selected @endif>
                                    {{ $w->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Tags:</strong>
                        <br>
                        @if($tags)
                            @foreach($tags as $t)
                                <input type="checkbox" name="tags[]" id="{{$t->id}}" value="{{$t->id}}" 
                                    {{ in_array($t->id, (array)old('tags', json_decode($workout->tags))) ? 'checked' : '' }}>
                                <label for="{{$t->id}}">{{$t->tag}}</label>
                                <br>
                            @endforeach
                        @endif
                    </div>
                </div>
                
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Exercises:</strong>
                        <br>
                        @if($exercises)
                        @foreach($exercises as $e)
                        <input type="checkbox" name="number_of_exercises[]" id="{{$e->id}}" value="{{$e->id}}" 
                            {{ in_array($e->id, (array)old('exercises', json_decode($workout->number_of_exercises))) ? 'checked' : '' }}>
                        <label for="{{$e->id}}">{{$e->name}}</label>
                        <br>
                    @endforeach
                        @endif
                    </div>
                </div>







                <div class="col-xs-12 col-sm-12 col-md-12">
                        <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
           
        </form>
    </div>
</div>
@endsection

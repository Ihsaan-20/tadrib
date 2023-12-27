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
        <form action="{{ route('workout.update', $workout->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Use the PUT method for updates -->

            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" name="name" value="{{ old('name', $workout->name) }}" class="form-control" placeholder="Workout Name">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Introductory video Video:</strong>
                        <input type="file" name="introductory_video" class="form-control">
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
                        <input type="number" name="rest" value="{{ old('rest', $workout->rest) }}" class="form-control" placeholder="Rest">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6"></div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Tags:</strong>
                        <br>
                        @if($tags)
                            @foreach($tags as $t)
                                <input type="checkbox" name="tags[]" id="{{$t->id}}" value="{{$t->id}}" 
                                       {{ in_array($t->id, (array)old('tags', $workout->tags)) ? 'checked' : '' }}>
                                <label for="option1">{{$t->tag}}</label>
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
                            @foreach($exercises as $t)
                                <input type="checkbox" name="number_of_exercises[]" id="{{$t->id}}" value="{{$t->id}}" {{ in_array($t->id, (array)old('number_of_exercises', $workout->number_of_exercises)) ? 'checked' : '' }}>
                                <label for="option1">{{$t->name}}</label>
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

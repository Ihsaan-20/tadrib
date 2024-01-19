@extends('frontend.layouts.app')

@section('app')
    <div class="row">
        <div class="col-md-10">
            <h2>Add New Exercise</h2>
        </div>
        <div class="col-md-2 ">
            <div class="float-right">
                <a class="btn btn-primary mt-3" href="{{ route('exercises.index') }}"> Back</a>
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
        <div class="col-lg-6">
            <form action="{{ route('exercises.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Name">
                        </div>
                    </div>
                   
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Text Bio:</strong>
                            <textarea name="text_bio" class="form-control" placeholder="Text Bio">{{ old('text_bio') }}</textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Repetitions:</strong>
                            <input type="text" name="repetitions" value="{{ old('repetitions') }}" class="phone_number form-control" placeholder="Repetitions">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Description Video:</strong>
                            <input type="file" name="video" class="form-control">
                        </div>
                    </div>
                </div>
                  <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Coach Name:</strong>
                        <select name='coach_id' class="form-control">
                            <option selected disabled>Select Coach</option>
                            @if($coach)
                                @foreach ($coach as $w)
                                <option value="{{$w->id}}">{{$w->name}}</option>  
                                @endforeach
                            @else
                                <option>No Found Coach</option>  
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('frontend.layouts.app')
@section('app')


<div class="row">
    <div class="col-md-10">
        <h2 >Add New Program</h2>
    </div>
    <div class="col-md-2 ">
        <div class="float-right">
            <a class="btn btn-primary mt-3" href="{{ route('program.index') }}"> Back</a>
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
   
<form action="{{ route('program.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
  
     <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" class="form-control" placeholder="Name">
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Description:</strong>
                <!-- Use textarea for multiline input -->
                <textarea name="description" class="form-control" placeholder="Description"></textarea>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Video:</strong>
                <input type="file"  name='introductory_video' class="form-control" placeholder="Video">
            </div>
        </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>External Video link:</strong>
                <input type="url"  name='external_video' class="form-control" placeholder="Video link">
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
             <div class="form-group">
                <strong>Thumbnail:</strong>
                <input type="file"  name='thumbnail' class="form-control" placeholder="Thumbnail">
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Text Bio:</strong>
                <!-- Use textarea for multiline input -->
                <textarea name="text_bio" class="form-control" placeholder="Text Bio"></textarea>
            </div>
        </div>
        
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Training Tags:</strong>
                <br>
               @foreach($tags as $t)
               @if($t->type == 'training')
                <input type="checkbox" name="training_type[]" id="{{$t->id}}" value="{{$t->id}}">
                <label for="option1">{{$t->tag}}</label>
                @endif
                <br>
          @endforeach
               
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Equipment Tags:</strong>
                <br>
               @foreach($tags as $t)
               @if($t->type == 'equipment')
                <input type="checkbox" name="tag_equipment[]" id="{{$t->id}}" value="{{$t->id}}">
                <label for="option1">{{$t->tag}}</label>
                @endif
            <br>
          @endforeach
               
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Coach Name:</strong>
                <select name='coach_id' class="form-control">
                    <option selected disabled>Select Coach</option>
                    @foreach ($coach as $w)
                    <option value="{{$w->id}}">{{$w->name}}</option>  
                    @endforeach
                    
                   </select>
               
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Duration (week):</strong>
                <input type="text" name='duration_weeks' class="phone_number form-control" placeholder="Duration (weeks)">
               
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Price (USD):</strong>
                <input type="text" name='price_usd' class="phone_number form-control" placeholder="Price in USD">
               
            </div>
        </div>

        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Level:</strong>
                <select name='level' class="form-control">
                    <option selected disabled>Select Level</option>
                   
                    <option value="Beginner">Beginner</option>  
                    <option value="Intermediate">Intermediate</option>  
                    <option value="Advanced">Advanced</option>  
                    
                   </select>
               
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">

            <div class="form-group">
                <strong>Workout:</strong>
                <br>
                @foreach($workout as $w)
                <input type="checkbox" name="number_of_workout[]" id="{{$w->id}}" value="{{$w->id}}">
                <label for="option1">{{$w->name}}</label>
            <br>
          @endforeach
               
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
   
</form>
@endsection

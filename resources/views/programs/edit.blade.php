@extends('frontend.layouts.app')
@section('app')
    <div class="row">
        <div class="col-md-10">
            <h2 >Edit Program</h2>
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
  
    <form action="{{ route('program.update',$program->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
   
         <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" value="{{ $program->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Description:</strong>
                    <input type="text" name="description" value="{{ $program->description }}" class="form-control" placeholder="Description">
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Training Tags:</strong>
                <br>
                @foreach($tags as $e)
                @if($e->type == 'training')
                    <input type="checkbox" name="training_type[]" id="{{$e->id}}" value="{{$e->id}}" 
                        {{ in_array($e->id, (array)old('exercises', json_decode($program->training_type))) ? 'checked' : '' }}>
                    <label for="{{$e->id}}">{{$e->tag}}</label>
                    @endif
                    <br>
                @endforeach
            </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Equipment Tools:</strong>
               
                @foreach($tags as $e)
                @if($e->type == 'equipment')
                    <input type="checkbox" name="tag_equipment[]" id="{{$e->id}}" value="{{$e->id}}" 
                        {{ in_array($e->id, (array)old('exercises', json_decode($program->tag_equipment))) ? 'checked' : '' }}>
                    <label for="{{$e->id}}">{{$e->tag}}</label>
                    @endif
                    <br>
                @endforeach
            </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Introductory video:</strong>
                    <input type="file" name="introductory_video" value="{{$program->introductory_video}}" class="form-control">
                </div>
            </div>
            
            
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group"><br>
                    @if($program->introductory_video)
                    <video width="150px" height="100px" controls>
                        <source src="{{ asset('storage/'.$program->introductory_video) }}" type="video/mp4">
                    </video>
                        @else
                            <img src="{{ asset('images/not.jpg')}}" style="width:70px; height:40px" alt="User" />
                    @endif
                </div>
            </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>External Video link:</strong>
                <input type="url"  name='external_video' value="{{$program->external_video}}" class="form-control" placeholder="Video link">
            </div>
        </div>

            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group">
                    <strong>Thumbnail:</strong>
                    <input type="file" name="thumbnail" value="{{$program->thumbnail}}" class="form-control">
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3">
                <div class="form-group"><br>
                    @if($program->thumbnail)
                   
                        <img src="{{ asset('storage/'.$program->thumbnail) }}" style="width:70px; height:40px" alt="User" />
                   
                        @else
                            <img src="{{ asset('images/not.jpg')}}" style="width:70px; height:40px" alt="User" />
                    @endif
                </div>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Coach Name:</strong>
                    <select name='coach_id' class="form-control">
                        <option selected disabled>Select Coach</option>
                        @foreach ($coach as $w)
                            <option value="{{ $w->id }}" @if ($program->coach_id == $w->id) selected @endif>
                                {{ $w->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Duration (week):</strong>
                    <input type="text" name='duration_weeks' class="phone_number form-control" value="{{$program->duration_weeks}}" placeholder="Duration (weeks)">
                   
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Price (USD):</strong>
                    <input type="text" name='price_usd' value="{{$program->price_usd}}"  class="phone_number form-control" placeholder="Price in USD">
                   
                </div>
            </div>

          <div class="col-xs-6 col-sm-6 col-md-6">
    <div class="form-group">
        <strong>Level:</strong>
        <select name='level' class="form-control">
            <option value='Select Level' disabled>Select Level</option>
            
            <option value="Beginner" @if($program->level == 'Beginner') selected @endif>Beginner</option>  
            <option value="Intermediate" @if($program->level == 'Intermediate') selected @endif>Intermediate</option>  
            <option value="Advanced" @if($program->level == 'Advanced') selected @endif>Advanced</option>  
        </select>
    </div>
</div>

            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Text Bio:</strong>
                    <input type="textarea" name="text_bio" value="{{$program->text_bio}}"  class="form-control" placeholder="Text Bio">
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">

                <div class="form-group">
                    <strong>Workouts:</strong>
                   
                    @foreach($workout as $e)
                  
                        <input type="checkbox" name="number_of_workout[]" id="{{$e->id}}" value="{{$e->id}}" 
                            {{ in_array($e->id, (array)old('workouts', json_decode($program->number_of_workout))) ? 'checked' : '' }}>
                        <label for="{{$e->id}}">{{$e->name}}</label>
                     
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
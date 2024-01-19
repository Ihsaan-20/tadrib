@extends('frontend.layouts.app')
@section('app')
    <div class="row">
        <div class="col-md-10">
            <h2 > Program Details</h2>
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
  
  
         <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Name:</strong>
                    <p>{{ $program->name }}</p>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Description:</strong>
                    <p>
                    {{ $program->description }}</p>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Training Tags:</strong>
                
               
                @if(json_decode($program->training_type) != null)
           
                @foreach(json_decode($program->training_type) as $t)
                @php
                
                    $s=App\Models\Tag::find($t);
                @endphp
                <p>{{$s->tag}}</p>
                    
                @endforeach
                @endif
            </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Equipment Tools:</strong>
               @if(json_decode($program->tag_equipment) != null)
                @foreach(json_decode($program->tag_equipment) as $t)
                @php
                
                    $s=App\Models\Tag::find($t);
                @endphp
                <p>{{$s->tag}}</p>
                  
                @endforeach
                @endif
            </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                
                    <strong>Introductory video:</strong>
                  
          
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

            <div class="col-xs-3 col-sm-3 col-md-3">
               
                    <strong>Thumbnail:</strong>
                   
           
                <div class="form-group"><br>
                    @if($program->thumbnail)
                   
                        <img src="{{ asset('storage/'.$program->thumbnail) }}" style="width:70px; height:40px" alt="User" />
                   
                        @else
                            <img src="{{ asset('images/not.jpg')}}" style="width:70px; height:40px" alt="User" />
                    @endif
                </div>
            </div>
   <div class="col-xs-6 col-sm-6 col-md-6">
                
                    <strong>Introductory video:</strong>
                  
          
                <div class="form-group"><br>
                    @if($program->external_video)
                   <a href="{{ $program->external_video }}"> <video width="150px" height="100px" controls>
                        <source src="{{ $program->external_video }}" >
                    </video></a>
                        @else
                            <img src="{{ asset('images/not.jpg')}}" style="width:70px; height:40px" alt="User" />
                    @endif
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Coach Name:</strong>
                    @php
                    $coach = App\Models\User::find($program->coach_id);
                  
                @endphp
                                  @if($coach) {{$coach->name}}@endif
                   
                </div>
            </div>
            
          
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Duration (week):</strong>
                    <p>{{$program->duration_weeks}}</p>
                   
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Price (USD):</strong>
                    <p>{{$program->price_usd}}</p>
                   
                </div>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Level:</strong>
                    <p>{{$program->level}}</p>
                   
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Text Bio:</strong>
                    <p>{{$program->text_bio}}</p>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">

                <div class="form-group">
                    <strong>Workouts:</strong>
                   
                    @if(json_decode($program->number_of_workout) != null)
                    @foreach(json_decode($program->number_of_workout) as $t)
                    @php
                    
                        $tag=App\Models\Workout::find($t);
                    @endphp
                    <p>{{$tag->name}}</p>
                        
                    @endforeach
                    @endif
                </div>
            </div>
           
        </div>
   
   
@endsection
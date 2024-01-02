@extends('frontend.layouts.app')
@section('app')
<div class="row">
    <div class="col-12">
       
             <div class="row">
             
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Set type:</strong>
                        <p>{{$set->set_type}}</p>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Exercises:</strong>
                        @foreach (json_decode($set->exercises) as $e)
                            @php
                                $tag = App\Models\Excercise::find($e);
                            @endphp
                        
                            @if ($tag)
                                <p>{{ $tag->name }}</p>
                                
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>No of Time:</strong>
                        <p>{{$set->no_of_time}}</p>
                    </div>
                </div>
        
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Inter Set Rest:</strong>
                        <p>{{$set->inter_set_rest}}</p>

                    </div>
                </div>
                
                
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Intra Set Rest:</strong>
                        <p>{{$set->intra_set_rest}}</p>

                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Duration:</strong>
                        <p>{{$set->estimated_duration}}</p>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Workout:</strong>
                        <p>{{$set->workout_name}}</p>
                    </div>
                </div>
              
            </div>
           
        
    </div>
</div>


@endsection
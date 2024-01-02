@extends('frontend.layouts.app')
@section('app')

<div class="row">
    <div class="col-md-10">
        <h2 >Add New Set</h2>
    </div>
    <div class="col-md-2 ">
        <div class="float-right">
            <a class="btn btn-primary mt-3" href="{{ url('set') }}"> Back</a>
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
        <form action="{{ url('set/store') }}" method="POST">
            @csrf
          
             <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Set Type:</strong>
                       <select name='set_type' class="form-control">
                        <option selected disabled>Select type</option>
                        <option value="set">Set</option>
                        <option value="super_set">Super Set</option>
                       </select>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">

                    <div class="form-group">
                        <strong>Exercises:</strong>
                        @foreach($exercise as $e)
                        <input type="checkbox" name="exercises[]" id="{{$e->id}}" value="{{$e->id}}">
                        <label for="option1">{{$e->name}}</label>
                    <br>
                  @endforeach
                       
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>No# of time:</strong>
                        <input type="number" name="no_of_time" class="form-control" placeholder="Number of Time">
                    </div>
                </div>
        
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Inter Set:</strong>
                        <input type="number" name="inter_set_rest" class="form-control" placeholder="Inter Rest">
                    </div>
                </div>
                
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Intra Set:</strong>
                        <input type="number" name="intra_set_rest" class="form-control" placeholder="Intra Rest">
                    </div>
                </div>
                
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Duration of Set:</strong>
                        <input type="time" name="estimated_duration" class="form-control" placeholder="Duration of Set">
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>Workout:</strong>
                        <select name='workout_id' class="form-control">
                            <option selected disabled>Select Workout</option>
                            @foreach ($workout as $w)
                            <option value="{{$w->id}}">{{$w->name}}</option>  
                            @endforeach
                            
                           </select>
                       
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
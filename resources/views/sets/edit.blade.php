@extends('frontend.layouts.app')
@section('app')
    <div class="row">
        <div class="col-md-10">
            <h2 >Sets</h2>
        </div>
        <div class="col-md-2 ">
            <div class="float-right">
                <a class="btn btn-primary mt-3" href="{{ route('set.index') }}"> Back</a>
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
  
    <form action="{{ route('set.update',$set->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
   
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Set Type:</strong>
                    <select name='set_type' class="form-control">
                        <option disabled>Select type</option>
                        <option value="set" @if($set->set_type == 'set') selected @endif>Set</option>
                        <option value="super_set" @if($set->set_type == 'super_set') selected @endif>Super Set</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">

              

                <div class="form-group">
                    <strong>Exercises:</strong>
                    @foreach($exercise as $e)
                        <input type="checkbox" name="exercises[]" id="{{$e->id}}" value="{{$e->id}}" 
                            {{ in_array($e->id, (array)old('exercises', json_decode($set->exercises))) ? 'checked' : '' }}>
                        <label for="{{$e->id}}">{{$e->name}}</label>
                        <br>
                    @endforeach
                </div>
                
        

            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>No# of time:</strong>
                    <input type="text" name="no_of_time" value="{{$set->no_of_time}}" class="phone_number form-control" placeholder="Number of Time">
                </div>
            </div>
    
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Inter Set:</strong>
                    <input type="text" name="inter_set_rest" value="{{$set->inter_set_rest}}" class="phone_number form-control" placeholder="Inter Rest">
                </div>
            </div>
            
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Intra Set:</strong>
                    <input type="text" name="intra_set_rest" value="{{$set->intra_set_rest}}" class="phone_number form-control" placeholder="Intra Rest">
                </div>
            </div>
            
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Duration of Set/ Minutes :</strong>
                    <input type="time" name="estimated_duration" value="{{$set->estimated_duration}}" class="form-control" placeholder="Duration of Set">
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Workout:</strong>
          


                       <select name='workout_id' class="form-control">
                       
                        @foreach ($workout as $w)
                            <option value="{{$w->id}}" @if ($w->id == $set->id) selected @endif>{{$w->name}}</option>
                        @endforeach
                    </select>
                    
                   
                </div>
            </div>
        
            <div class="col-xs-12 col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection
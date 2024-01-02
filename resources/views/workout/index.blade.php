@extends('frontend.layouts.app')
@section('app')
    <div class="row">
        <div class="col-md-10">
            <h2 >Workout</h2>
        </div>
        <div class="col-md-2 ">
            <div class="float-right">
                <a class="btn btn-primary mt-3" href="{{ url('workout/create') }}"> Add</a>
            </div>
        </div>
    </div>
   
    {{-- @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif --}}
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
        
         
            <th width="280px">Action</th>
        </tr>
        @foreach ($workout as $workouts)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $workouts->name }}</td>
        
            <td>
                <form action="{{ route('workout.destroy',[$workouts->id]) }}" method="POST">
   
                    <a class="btn btn-primary" href="{{ route('workout.show',[$workouts->id]) }}">Show</a>
    
                    <a class="btn btn-primary" href="{{ route('workout.edit',[$workouts->id]) }}">Edit</a>
   
                    @csrf
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $workout->links() !!}
      
@endsection
@extends('frontend.layouts.app')
@section('app')
    <div class="row">
        <div class="col-md-10">
            <h2 >Sets</h2>
        </div>
        <div class="col-md-2 ">
            <div class="float-right">
                <a class="btn btn-primary mt-3" href="{{ url('set/create') }}"> Add</a>
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
            <th>Set Type</th>
            <th>Workout Name</th>
            <th>Estimated Duration</th>
            <th>Inter Set Rest</th>
            <th>Intra Set Rest</th>
            <th width="280px">Action</th>
        </tr>
        <tbody>
            @foreach ($set as $s)
        <tr>
            <td>{{ ++$i }}</td>
            <td>
                @if($s->set_type === 'super_set')
                Super Set
                @else
                Set
                @endif
                {{-- {{$s->set_type}} --}}
            
            </td>
            <td>{{$s->workout_name}}</td>
            <td>{{$s->estimated_duration}}</td>
            <td>{{$s->inter_set_rest}}</td>
            <td>{{$s->intra_set_rest}}</td>
            <td>
                <form action="{{ route('set.destroy',[$s->id]) }}" method="POST">
   
                    <a class="btn btn-info" href="{{ url('set/show/'.$s->id) }}">Show</a>
    
                    <a class="btn btn-primary" href="{{ url('set/edit/'.$s->id) }}">Edit</a>
   
                    @csrf
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
            <tr>
            @endforeach
           
        </tbody>
       
    </table>
  
  
      
@endsection
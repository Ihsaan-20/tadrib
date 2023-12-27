@extends('frontend.layouts.app')
@section('app')
    <div class="row">
        <div class="col-md-10">
            <h2 >Users</h2>
        </div>
        <div class="col-md-2 ">
            <div class="float-right">
                <a class="btn btn-primary mt-3" href="{{ url('user/create') }}"> Add</a>
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
            <th>Email</th>
            <th>Phone Number</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($coachs as $coach)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $coach->name }}</td>
            <td>{{ $coach->email }}</td>
            <td>{{ $coach->phone_number }}</td>
       
            <td>
                <form action="{{ route('user.destroy',[$coach->id]) }}" method="POST">
   
                    <a class="btn btn-info" href="{{ url('user/show/'.$coach->id) }}">Show</a>
    
                    <a class="btn btn-primary" href="{{ url('user/edit/'.$coach->id) }}">Edit</a>
   
                    @csrf
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {!! $coachs->links() !!}
      
@endsection
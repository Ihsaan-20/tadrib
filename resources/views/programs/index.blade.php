@extends('frontend.layouts.app')
@section('app')
    <div class="row">
        <div class="col-md-10">
            <h2 >PROGRAMS</h2>
        </div>
        <div class="col-md-2 ">
            <div class="float-right">
                <a class="btn btn-primary mt-3" href="{{ route('program.create') }}"> Create New Program</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Description</th>
            <th>progress</th>
            <th>Tag</th>
     <th width="280px">Action</th>
        </tr>
        @foreach ($programs as $program)
        <tr>
            <td>{{++$loop->index}}</td>
            <td>{{ $program->name }}</td>
            <td>{{ $program->description }}</td>
            <td>{{ $program->progress }}</td>
           {{-- <td>{{ $program->tag->tag }}</td>--}}
           <td>
                            @foreach($program->tags as $tag)
                                {{ $tag->tag }}@if(!$loop->last), @endif
                            @endforeach
                        </td>
            <td>
                <form action="{{ route('programs.destroy',$program->id) }}" method="POST">
   
                    <a class="btn btn-info" href="{{ route('programs.show',$program->id) }}">Show</a>
    
                    <a class="btn btn-primary" href="{{ route('programs.edit',$program->id) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  

@endsection
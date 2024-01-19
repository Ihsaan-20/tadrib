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
   
    {{-- @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif --}}
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Description</th>
            <th>Text Bio</th>
            <th>Coach</th>
            <th>Level</th>
            <th>Duration (week)</th>
     <th width="280px">Action</th>
        </tr>
        @foreach ($programs as $program)
        <tr>
            <td>{{++$loop->index}}</td>
            <td>{{ $program->name }}</td>
            <td>{{ $program->description }}</td>
            <td>{{ $program->text_bio }}</td>
           {{-- <td>{{ $program->tag->tag }}</td>--}}
           <td>
            @php
            $coach = App\Models\User::find($program->coach_id);
          
        @endphp
                         @if($coach)  {{$coach->name}}@endif
                        </td>
                        <td>{{ $program->level }}</td>
                        <td>{{ $program->duration_weeks }} weeks</td>
            <td>

              
    <a class="btn btn-info" href="{{ route('program.show', $program->id) }}">Show</a>
    <a class="btn btn-primary" href="{{ route('program.edit', $program->id) }}">Edit</a>
    <a class="btn btn-primary" href="{{ route('program.destroy', $program->id) }}">Delete</a>


            </td>
        </tr>
        @endforeach
    </table>
  

@endsection
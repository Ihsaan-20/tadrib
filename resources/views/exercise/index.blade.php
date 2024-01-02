@extends('frontend.layouts.app')
@section('app')
    <div class="row">
        <div class="col-md-10">
            <h2 >Exercies</h2>
        </div>
        <div class="col-md-2 ">
            <div class="float-right">
                <a class="btn btn-primary mt-3" href="{{ route('exercises.create') }}"> Create New Exercies</a>
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
           
            <th>Bio</th>
            <th>Repetitions</th>
            <th>Video</th>
            
            <th width="280px">Action</th>
        </tr>
        @if($exercise)
        @foreach ($exercise as $key=> $exercises)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{ $exercises->name }}</td>
            <td>{{ $exercises->text_bio }}</td>
            <td>{{ $exercises->repetitions }}</td>
          
            <td>

                @if($exercises->description_video)
                <video width="150px" height="150px" controls>
                    <source src="{{ asset('storage/exercise_videos/'.$exercises->description_video) }}" type="video/mp4">
                </video>
                    @else
                        <img src="{{ asset('images/not.jpg')}}" style="width:70px; height:40px" alt="User" />
                @endif


               
            </td>
            
            
            <td>
                <form action="{{ route('exercises.destroy',$exercises->id) }}" method="POST">
   
                    {{-- <a class="btn btn-info" href="{{ route('tags.show',$tag->id) }}">Show</a> --}}
    
                    <a class="btn btn-primary" href="{{ route('exercises.edit',$exercises->id) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
        @endif
    </table>
  
    {!! $exercise->links() !!}
      
@endsection
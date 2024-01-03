@extends('frontend.layouts.app')
@section('app')
    <div class="row">
        <div class="col-md-10">
            <h2 >TAGS</h2>
        </div>
        <div class="col-md-2 ">
            <div class="float-right">
                <a class="btn btn-primary mt-3" href="{{ route('tags.create') }}"> Create New Tag</a>
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
            <th>Tag Type</th>
            <th>Image</th>
            
            <th width="280px">Action</th>
        </tr>
        @if($tags)

      
        @foreach ($tags as $tag)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $tag->tag }}</td>
            <td>{{ $tag->type }}</td>
            <td>
                @if($tag->photo)
                <img src="{{ asset('storage/tags/profile/'.$tag->photo)}}" style="width:70px; height:40px" alt="User" />
                @else
                <img src="{{ asset('images/not.jpg')}}" style="width:70px; height:40px" alt="User" />
                @endif
            
            </td>
            
            <td>
                <form action="{{ route('tags.destroy',$tag->id) }}" method="POST">
   
                    {{-- <a class="btn btn-info" href="{{ route('tags.show',$tag->id) }}">Show</a> --}}
    
                    <a class="btn btn-primary" href="{{ route('tags.edit',$tag->id) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
        @endif
    </table>
  
    {!! $tags->links() !!}
      
@endsection
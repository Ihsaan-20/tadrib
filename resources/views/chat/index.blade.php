@extends('frontend.layouts.app')
@section('app')
<h1>Chat Section</h1>

<a href="{{route('chat.user')}}" class="btn btn-primary">Chat to  users</a>
<a href="{{route('chat.user')}}" class="btn btn-primary">Chat to  Coach</a>
<a href="{{route('chat.user')}}" class="btn btn-primary">Create group chat</a>



@endsection
@section('customJs')
    <script>
        // alert('working');
    </script>
@endsection
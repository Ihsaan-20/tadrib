@extends('frontend.layouts.app')

@section('app')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-10">
            <h2>{{ $workout->name }}</h2>
        </div>
        <div class="col-md-2">
            <div class="float-right">
                <a class="btn btn-primary mt-3" href="{{ url('workout') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <strong>Introductory Video:</strong>
            <div class="mb-4">
                @if ($workout->introductory_video)
                    <video width="320" height="240" controls>
                        <source src="{{ asset('storage/introductory_video/' . $workout->introductory_video) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <p>No introductory video available.</p>
                @endif
            </div>

            <p><strong>Bio:</strong> {{ $workout->text_bio }}</p>
            <p><strong>Estimated Duration:</strong> {{ $workout->estimated_duration_hours }}</p>
            <p><strong>Rest (in days):</strong> {{ $workout->rest }}</p>

            <p class="mt-3"><strong>Tags:</strong></p>
            <ul class="list-unstyled">
                @if($workout->tags)
                @foreach (json_decode($workout->tags) as $tag_id)
                    @php
                        $tag = App\Models\Tag::find($tag_id);
                    @endphp
                
                    @if ($tag)
                        <li class="badge badge-primary">{{ $tag->tag }}</li>
                    @endif
                @endforeach
                @endif
            </ul>

            <p class="mt-3"><strong>Exercises:</strong></p>
            <ul class="list-unstyled">
                @if($workout->number_of_exercises)
                @foreach (json_decode($workout->number_of_exercises) as $exercise_id)
                    @php
                        $exercise = App\Models\Exercise::find($exercise_id);
                    @endphp
                
                    @if ($exercise)
                        <li class="badge badge-success">{{ $exercise->name }}</li>
                    @endif
                @endforeach
                 @endif
            </ul>
        </div>
    </div>
</div>
@endsection

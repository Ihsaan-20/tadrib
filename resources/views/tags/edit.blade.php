@extends('frontend.layouts.app')
@section('app')
    <div class="row">
        <div class="col-md-10">
            <h2>Edit Tag</h2>
        </div>
        <div class="col-md-2 ">
            <div class="float-right">
                <a class="btn btn-primary mt-3" href="{{ route('tags.index') }}"> Back</a>
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

    <div class="row">
        <div class="col-12">
            <div class="col-lg-6">
                <form action="{{ route('tags.update', $tag->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                <input type="text" name="tag" value="{{ $tag->tag }}" class="form-control"
                                    placeholder="Name">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Type:</strong>
                                <select name="type" class="form-control">
                                    <option disabled>Select Type</option>
                                    <option value="training" {{ $tag->type == 'training' ? 'selected' : '' }}>Training
                                    </option>
                                    <option value="equipment" {{ $tag->type == 'equipment' ? 'selected' : '' }}>Equipment
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Image:</strong>
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            @if($tag->photo)
                                    <img src="{{ asset('storage/tags/profile/'.$tag->photo)}}" style="width:70px; height:40px" alt="User" />
                                @else
                                    <img src="{{ asset('images/not.jpg')}}" style="width:70px; height:40px" alt="User" />
                            @endif
                        </div>
                        <br>
                        <br>
                        <br>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

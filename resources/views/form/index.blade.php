
@extends('frontend.layouts.app')
@section('app')

<div class="card-body">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Program Name</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
               <?php 
            //    dd($decode);
                
                // $decode = json_decode($data);
                // echo '<pre>'.print_r($decode);.'</pre>'
                // $decode;
                ?>
                @foreach($decode as $key => $program)
                    
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            @php
                                $programs = json_decode($program->program);
                            @endphp
                            {{-- {{ dd($programs) }} --}}
                            {{-- {{ dd($programs->program_name) }} --}}
                            {{ $programs->program_name }}
                            {{-- {{ $program->program }} --}}
                        </td>
                        <td> 
                            <a href="{{ route('form.edit', ['id' => $program->id]) }}">Edit</a>
                            <a href="{{ route('form.destroy', ['id' => $program->id]) }}">Delete</a>
                        </td>
                    </tr>
                       
                    
                    
                @endforeach
            </tbody>
            
        </table>
    </div>

</div>

@endsection

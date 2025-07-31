@extends('admin.layout.app')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row mx-0 mt-3">
        <div class="col-lg-5">
            <h3 class="mb-5">Edit Type</h3>

            <form action="{{ route('tags.update', $tag->id) }}" method="POST" class="mb-3">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control border border-primary" required placeholder="Enter Tag Name" value="{{ $tag->name }}">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror   
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="background_color" class="form-label">Background (Hex Code of color)</label>
                            <input type="text" name="background_color" id="background_color" class="form-control border border-primary" required placeholder="Enter Tag Banckground color" value="{{$tag->background_color }}">
                            @error('background_color')
                                <div class="text-danger">{{ $message }}</div>   
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="text_color" class="form-label">Text Color (Hex Code of color)</label>
                            <input type="text" name="text_color" id="text_color" class="form-control border border-primary" required placeholder="Enter Tag Text color" value="{{ $tag->text_color }}">
                            @error('text_color')
                                <div class="text-danger">{{ $message }}</div>   
                            @enderror
                        </div>
                    </div>

                    <div class="offset-4 col-4">
                        <div class="pickshell">
                            <div class="picker" data-hsv="180,60,78">
                                <a href="#change" class="icon change"></a>
                                <input type="text" class="change" name="change" value="" />
                                <div class="board">
                                    <div class="choice"></div>
                                </div>
                                <div class="rainbow">
                                    <div class="rainbow-style"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>        
    </div>
@endsection
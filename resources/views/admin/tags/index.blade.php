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
        <div class="col-lg-12">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed text-white fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Add Tag
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body bg-white">
                        <form action="{{ route('tags.store') }}" method="POST" class="mb-3">
                            @csrf

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="name" class="form-label">Tag Name<span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control border border-primary" required placeholder="Enter tag name" value="{{ old('name') }}">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>   
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="background_color" class="form-label">Background Color<span class="text-danger">*</span></label>
                                            <input type="text" name="background_color" id="background_color" class="form-control border border-primary" required placeholder="Enter background color" value="{{ old('background_color') }}">
                                            @error('background_color')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="text_color" class="form-label">Text Color<span class="text-danger">*</span></label>
                                            <input type="text" name="text_color" id="text_color" class="form-control border border-primary" required placeholder="Enter text color" value="{{ old('text_color') }}">
                                            @error('text_color')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
            
                                <div class="col-md-4">
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
                </div>
            </div>
        </div>
        <div class="col-lg-12 mt-lg-0 mt-5">

            <div class="h-100 p-2">
                <h3 class="mb-5">Tags</h3>
                <div class="table-responsive">
                    <table class="table table-striped" id="tagsTable"> 
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tags as $tag)
                                <tr class="align-middle">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span style="background:{{$tag->background_color}}; color:{{$tag->text_color}}; padding:3px; border-radius: 5px;">{{ $tag->name }}  </span>                                                                  
                                    </td>
                                    <td>
                                        <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this tag?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#tagsTable').DataTable({
            });
        });
    </script>
@endpush

@extends('layout.master');

@section('title', 'Mini Blog System')

@section('content')
     <div class="container mt-3">
        <div class="row">
            <div class="col-6 offset-3">
                <div class="d-flex justify-content-end my-2">
                    <a href="{{ route('blog#list') }}" class="btn btn-outline-primary ">Back</a>
                </div>
                <form action="{{ route('blog#update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-center my-3">
                                <img src="{{ asset('blogImages/' . $data->image) }}" width="80px" height="80px" alt="">
                            </div>
                            {{-- old image name send --}}
                            <input type="hidden" name="oldImage" value="{{ $data->image }}">
                            <input type="text" name="title" value="{{ old('title' , $data->title) }}"
                                placeholder="Enter Blog Title..."
                                class="form-control w-100 @error('title')
                            is-invalid
                        @enderror">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <textarea name="description" value="{{ old('description') }}" placeholder="Enter Message..." cols="10"
                                rows="10"
                                class="form-control w-100 mt-2 @error('description')
                            is-invalid
                        @enderror">{{ old('description' , $data->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <input type="file" name="image"
                                class="form-control w-100 mt-2 @error('image')
                            is-invalid
                        @enderror">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <input type="text" name="ownerName" value="{{ old('ownerName' , $data->owner_name)  }}"
                                placeholder="Enter Owner Name..."
                                class="form-control mt-2 @error('ownerName')
                            is-invalid
                        @enderror">
                            @error('ownerName')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="d-flex justify-content-center mt-3">
                                <input type="submit" value="Create" class="btn btn-primary w-25">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@extends('layout.master');

@section('title', 'Mini Blog System')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-5">
                @if (Session::has('status'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ Session::get('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form action="{{ route('blog#create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <input type="text" name="title" value="{{ old('title') }}"
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
                        @enderror">{{ old('description') }}</textarea>
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
                            <input type="text" name="ownerName" value="{{ old('ownerName') }}"
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
            <div class="col">
                {{-- search --}}
                <form action="{{ route('blog#list') }}" method="get">
                    @csrf
                    <div class="d-flex justify-content-end">
                        <div class="input-group mb-3 w-50">
                            <input type="text" name="searchKey" value="{{ request('searchKey') }}" class="form-control " placeholder="Enter search key...">
                            <button type="submit" class="btn btn-outline-primary input-group-text"><i class="fa-solid fa-magnifying-glass "></i></button>
                        </div>
                    </div>
                </form>
                @if (count($data) != 0)
                    @foreach ($data as $item)
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <img src="{{ asset('blogImages/' . $item->image) }}" width="50px" height="50px"
                                        class="rounded-circle border-1" alt="">
                                </div>
                                <h5 class="col-7 mt-2">{{ $item->title }}</h5>
                                <div class="col-3 mt-2">
                                    <a href="{{ route('blog#edit', $item->id) }}"><button
                                            class="btn btn-outline-primary btn-sm"><i
                                                class="fa-solid fa-pen-to-square fs-5"></i></button></a>
                                    <button type="button" onclick="dataDelete({{ $item->id }})"
                                        class="btn btn-outline-danger btn-sm"><i
                                            class="fa-solid fa-trash mx-2 fs-5"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @else
                    <h6 class="text-center text-muted my-3">No data found...</h6>
                @endif

                <span>{{ $data->links() }}</span>

            </div>
        </div>
    </div>
@endsection

@section('js_sweet')

    <script>
        function dataDelete($id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });

                    // setInterval(() => {
                    //     location.href = "/blog/delete/"+$id
                    // }, 1000);

                    location.href = "/blog/delete/" + $id
                }

            });
        }
    </script>

@endsection

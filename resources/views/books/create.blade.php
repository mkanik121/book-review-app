@extends('layout.app')
@section('main')
<div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-lg">
                    <div class="card-header  text-white">
                        Welcome, {{ Auth::user()->name }}                       
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                             @if(Auth::user()->image != "")
                            <img src="{{ asset('uploads/profile/thumb/'.Auth::user()->image)}}" class="img-fluid rounded-circle" alt="Luna John">                            
                             @endif
                        </div>
                        <div class="h5 text-center">
                            <strong>{{ Auth::user()->name }}   </strong>
                            <p class="h6 mt-2 text-muted">5 Reviews</p>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-lg mt-3">
                    <div class="card-header  text-white">
                        Navigation
                    </div>
                    <div class="card-body sidebar">
                    @include('layout.sidebar')
                    </div>
                </div>
            </div>
            <div class="col-md-9">
            @include('layout.message')
            <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        Add Book
                    </div>
                    <div class="card-body">
                      <form action="{{ route('books.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" value="{{ old('title') }}" class="@error('title') is-invalid @enderror form-control" placeholder="Title" name="title" id="title" />
                         @error('title')
                         <p class="invaild-feedback">{{ $message}}</p>
                         @enderror
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" value="{{ old('author') }}" class="@error('author') is-invalid @enderror form-control" placeholder="Author"  name="author" id="author"/>
                         @error('author')
                         <p class="invaild-feedback">{{ $message}}</p>
                         @enderror
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Description" cols="30" rows="5"> {{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="Image" class="form-label">Image</label>
                            <input type="file" class="@error('image') is-invalid @enderror form-control"  name="image" id="image"/>
                         @error('image')
                         <p class="invaild-feedback">{{ $message}}</p>
                         @enderror
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Status</label>
                            <select name="status" id="status" class="@error('status') is-invalid @enderror form-control">
                                <option value="1">Active</option>
                                <option value="0">Block</option>
                            </select>
                         @error('status')
                         <p class="invaild-feedback">{{ $message}}</p>
                         @enderror
                        </div>


                        <button class="btn btn-primary mt-2">Create</button>   
                    </form>                  
                    </div>
                </div> 
        </div>       
    </div>
@endsection

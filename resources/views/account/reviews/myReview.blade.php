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
                        My Reviews
                    </div>
                    <div class="card-body pb-0">      
                    <div class="d-flex justify-content-end">
                              <form action="" method="get">
                                    <div class="d-flex">
                                        <input type="text" name="keyword" class="form-control" value="{{ Request::get('keyword') }}" placeholder="keyword">
                                        <button type="submit" class="btn btn-primary ms-2">Search</button>
                                        <a href="{{ route('account.myReviews') }}" class="btn btn-dark ms-2">Clear</a>
                                        
                                    </div>           
                               </form>
                          </div>        
                        <table class="table  table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Book</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                    <th>Status</th>                                  
                                    <th width="100">Action</th>
                                </tr>
                                <tbody>
                                    @if($myReview->isNotEmpty())
                                    @foreach($myReview as $MyReview)
                                    <tr>
                                        <td>{{ $MyReview->book->title}}</td>
                                        <td>{{ $MyReview->review}}</td>                                         
                                        <td>{{ $MyReview->rating}}</td>                                         
                                        <td>Active</td>
                                        <td>
                                            <a href="edit-review.html" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>    
                                    @endforeach
                                    @endif                              
                                </tbody>
                            </thead>
                        </table>   
                       {{ $myReview->links() }}                 
                    </div>
                    
                </div>               
            </div>
        </div>       
    </div>
@endsection

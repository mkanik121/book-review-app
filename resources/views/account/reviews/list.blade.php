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
                        Reviews
                    </div>
                    <div class="card-body pb-0">         
                    <div class="d-flex justify-content-end">
                              <form action="" method="get">
                                    <div class="d-flex">
                                        <input type="text" name="keyword" class="form-control" value="{{ Request::get('keyword') }}" placeholder="keyword">
                                        <button type="submit" class="btn btn-primary ms-2">Search</button>
                                        <a href="{{ route('list.review') }}" class="btn btn-dark ms-2">Clear</a>
                                        
                                    </div>           
                               </form>
                          </div>    
                    

                        <table class="table  table-striped mt-3">
                            <thead class="table-dark">
                                <tr>
                                    <th>Review</th>
                                    <th>Book</th>
                                    <th>Rating</th>
                                    <th>Created at</th>  
                                    <th>Status</th>                                  
                                    <th width="100">Action</th>
                                </tr>
                                <tbody>
                                    @if($reviews->isNotEmpty())
                                    @foreach($reviews as $review)
                                    <tr>
                                        <td>{{ $review->review}} </br> <strong>{{ $review->user->name}}</strong></td>
                                        <td>{{ $review->book->title}}</td>
                                        <td><i class="fa-regular fa-star"></i>{{ $review->rating}}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($review->created_at)->format('d M, Y') }}
                                        </td>
                                        <td>
                                        @if($review->status ==1)
                                        <span class="text-success">Active</span>
                                        @else
                                        <span class="text-danger">Pending</span>
                                        @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('list.reviewEdit', $review->id) }}" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a href="#" onclick="deleteReview( {{ $review->id}})" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                <td>
                                <h3>No Book Added</h3>
                                </td>

                                    @endif
                                  
                                </tbody>
                            </thead>
                        </table>   
                 {{ $reviews->links() }}                 
                    </div>
                    
                </div>                
            </div>
        </div>       
    </div>
@endsection

@section('script')
 
 <script>
   function deleteReview(id){
    if(confirm('are you sure went to delete this review?')){
        $.ajax({
            url: "{{ route('list.reviewDelete') }}",
            data: {id:id},
            type: 'post',
            headers:{
                'X-CSRF-TOKEN' : '{{ csrf_token() }}'
            },
            success: function(response){
               window.location.href = "{{ route('list.review') }}";
            }
        });
    }
   }
 </script>
 
@endsection
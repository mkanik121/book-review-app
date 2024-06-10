<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    
    public function index(){

        $book = Book::orderBy('created_at','DESC')->where('status',1)->get();
        return view('home', ['book' => $book]);
    }

    public function BookDetail($id){
     $book = Book::with(['reviews.user', 'reviews' => function($query){ 
        $query->where('status',1);
     }])->findOrFail($id);
    
     if($book->status == 0){
        abort(404);
     }
     $RelatedBook = Book::where('status', 1)->take(3)->where('id','!=', $id)->inRandomOrder()->get();
        return view('book_detail', ['book' => $book],
        ['RelatedBook'=> $RelatedBook],
    );
    }

    public function StoreReview(Request $req){
         
        $validator = Validator::make($req->all(),[
            'review' => 'required|min:8',
            'rating' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
           
        $countReview = Review::where('user_id', Auth::user()->id)->where('book_id', $req->book_id)->count();

        if($countReview > 0){
             session()->flash('error', 'Review allready Submitted For This Book');
             return response()->json([
                'status' => true,
             ]);
        }
        $Review = new Review();

        $Review->review = $req->review;
        $Review->rating = $req->rating;
        $Review->user_id = Auth::user()->id;
        $Review->book_id = $req->book_id;

        $Review->save();

        session()->flash('success', 'Review Submited Successfully.');
       return response()->json([
        'status' => true,
       ]);
    }
}

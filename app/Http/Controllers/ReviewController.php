<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    
    public function index(Request $req){

        $review = Review::with('book')->orderBy('created_at', 'DESC');
        if(!empty($req->keyword)){
            $review = $review->where('review', 'like', '%'. $req->keyword.'%');
        }
        $review = $review->paginate(10);
        return view('account.reviews.list',['reviews' =>$review]);
    }

    public function reviewEdit($id){
        $review = Review::findOrFail($id);

        return view('account.reviews.edit', ['review' => $review]);
    }

    public function reviewUpdate($id, Request $req){
        $review = Review::findOrFail($id);
        $validator = Validator::make($req->all(),[
          'review' => 'required|min:8'
        ]);
        if($validator->fails()){
            return redirect()->route('list.reviewEdit', $id)->withInput()->withErrors($validator);
        }

        $review->review = $req->review;
        $review->status = $req->status;
        $review->save();

        session()->flash('success', 'Review Updated SuccessFully.');
        return redirect()->route('list.review');
    }

    public function reviewDelete(Request $req){
      
        $review = Review::find($req->id);
        
        if($review == null){

            session()->flash('error', 'Review Value Null');
            return response()->json([
                'status' => false
            ]);
        }else{
            $review->delete();
            session()->flash('success', 'Review Deleted Succssfully');
            return response()->json([
                'status' => false
            ]);

        }

    }
}

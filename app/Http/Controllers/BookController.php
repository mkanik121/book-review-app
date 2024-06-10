<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Book;

class BookController extends Controller
{
    
        // This Method Will Show Book Listing Page
        public function index(Request $req){
        
            $book =Book::orderBy('created_at', 'DESC');
            if(!empty($req->keyword)){
             $book->where('title','LIKE', '%'.$req->keyword.'%');
            }

        
            $book = $book->paginate(3);
       return view('books.list',['books'=>$book]);
        }
        // This Method Will Show Create Book Page
        public function create(){
         return view('books.create');
        }
        // This Method Will Store a Book
        public function store(Request $req){

            $rules = [
                'title' => 'required|min:5',
                'author' => 'required|min:3',
                'status' => 'required',
            ];

            if(!empty($req->image)){
                $rules['image'] = 'image';
            };
            $validator = Validator::make($req->all(), $rules);

            if($validator->fails()){
                return redirect()->route('books.create')->withInput()->withErrors($validator);
            }

            $book = new Book();

            $book->title       = $req->title;
            $book->author      = $req->author;
            $book->description = $req->description;
            $book->status      = $req->status;
            $book->save();
         
            if(!empty($req->image)){

                $image = $req->image;
                $ext = $image->getClientOriginalExtension();
                $imageName = time().'.'.$ext;
                $image->move(public_path('uploads/books'), $imageName);
                $book->image = $imageName;
                $book->save();
                $manager = new ImageManager(Driver::class);
                $img = $manager->read(public_path('uploads/books/'.$imageName));
                $img->resize(900);
                $img->save(public_path('uploads/books/thumb/'.$imageName));
            }


            return redirect()->route('books.list')->with('success', 'A book Succesfully Add In Database');

    
        }  
        // This Method Will Edit Page
        public function edit($id){
        $book = Book::FindorFail($id);
         return view('books.edit', ['book' => $book]);
        }  
         // This Method Will Update a Book
        public function update(Request $req, $id){
            $book = Book::FindorFail($id);
            $rules = [
                'title' => 'required|min:5',
                'author' => 'required|min:3',
                'status' => 'required',
            ];

            if(!empty($req->image)){
                $rules['image'] = 'image';
            };
            $validator = Validator::make($req->all(), $rules);

            if($validator->fails()){
                return redirect()->route('books.edit',$book->id)->withInput()->withErrors($validator);
            }



            $book->title       = $req->title;
            $book->author      = $req->author;
            $book->description = $req->description;
            $book->status      = $req->status;
            $book->save();
         
            if(!empty($req->image)){
                File::delete(public_path('uploads/books/thumb/'. $book->image));
                File::delete(public_path('uploads/books/'. $book->image));
                $image = $req->image;
                $ext = $image->getClientOriginalExtension();
                $imageName = time().'.'.$ext;
                $image->move(public_path('uploads/books'), $imageName);
                $book->image = $imageName;
                $book->save();
                $manager = new ImageManager(Driver::class);
                $img = $manager->read(public_path('uploads/books/'.$imageName));
                $img->resize(900);
                $img->save(public_path('uploads/books/thumb/'.$imageName));
            }


            return redirect()->route('books.list')->with('success', 'A book Updated Succesfully');

    
        }    
         // This Method Will Delete a Book
         public function delete(Request $req){
            $book = Book::find($req->id);

            if($book == null){
                session()->flash('error', 'Book Not Found');
                return response()->json([
                    'status' => false,
                    'message' => 'Book Not Found'
                ]);
            }else{
                File::delete(public_path('uploads/books/thumb/'. $book->image));
                File::delete(public_path('uploads/books/'. $book->image));
                $book->delete();
                session()->flash('success', 'Book Deleted Sucessfully');
                return response()->json([
                    'status' => true,
                    'message' => 'Book Deleted Sucessfully'
                ]);
            }

    
         }    


}

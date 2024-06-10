<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\User;
use App\Models\Review;


class AccountController extends Controller
{
    //   This Method Will Show Register Page
    public function register(){
            return view('account.register');
        }
    // This Method WIll Register a user 
    public function ProcessRegister(Request $req){
   
        $validator = Validator::make($req->all(),[
            'name'                  => 'required|min:3',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|confirmed|min:5',
            'password_confirmation' => 'required',
        ]);
        if($validator->fails()){
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }

        // If Pass Validator
        $user = new User();

        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->save();

        return redirect()->route('account.login')->with('success', 'You have registerd Succesfully');
    }

    // This Method Will Show Login Page
    public function login(){
            return view('account.login');
        }

    // This Method Will Authentic User
    public function auhtnticate(Request $req){
        $validator = Validator($req->all(), [
            'email'  => 'required|email',
            'password'  => 'required',
        ]);

        if($validator->fails()){
            return redirect()->route('account.login')->withInput()->withErrors($validator);
        };

        if(Auth::attempt(['email' => $req->email, 'password' => $req->password])){
          return redirect()->route('account.profile');
        }else{
            return redirect()->route('account.login')->with('error', 'Your email/password Incorrect');
        }
       }

    // This Method Will Show Profile Page
       public function profile(){
        $user = User::find(Auth::user()->id);
        return view('account.profile', ['user' => $user]);
       }


    // This Method Will Update Profile
    public function ProfileUpdate(Request $req){

        $rules =  [
            'name'  => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id.',id',
        ];
        if(!empty($req->image)){
            $rules['image'] = 'image';
        }
        $validator = Validator::make($req->all(),$rules);

        if($validator->fails()){
            return redirect()->route('account.profile')->withInput()->withErrors($validator);
        }
        $user = User::find(Auth::user()->id);
        $user->name = $req->name;
        $user->email = $req->email;
        $user->save();
    
        if(!empty($req->image)){
         FIle::delete(public_path('uploads/profile/'.$user->image));
         FIle::delete(public_path('uploads/profile/thumb/'.$user->image));
         $image = $req->image;
         $ext = $image->getClientOriginalExtension();
         $imageName = time().'.'.$ext;
         $image->move(public_path('uploads/profile'),$imageName);
         $user->image = $imageName;
         $user->save();

         $manager = new ImageManager(Driver::class);
         $img = $manager->read(public_path('uploads/profile/'.$imageName));
         $img->cover(150, 150);
         $img->save(public_path('uploads/profile/thumb/'.$imageName));
        }
        return redirect()->route('account.profile')->with('success', 'Profile Updated Succesfully');

       }
       
    // This Method Will LogOut user
    public function logout(){
        Auth::logout();
        return redirect()->route('account.login');
       }

       public function myReviews(Request $req){

        $myReview = Review::with('book')->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC');
       
        
         if(!empty($req->keyword)){
            $myReview = $myReview->where('review', 'like','%'. $req->keyword.'%');
         }
        
         $myReview = $myReview->paginate(2);

        return view('account.reviews.myReview', ['myReview' => $myReview]);
       }

}

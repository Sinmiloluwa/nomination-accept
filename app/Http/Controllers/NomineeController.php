<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Nominee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NomineeController extends Controller
{
    public function accept(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fullname' => 'required',
            'email' => 'required|email',
            'category' => 'required',
            'country_of_origin' => 'required',
            'country_of_residence' => 'required',
            'years_of_experience' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'validation Error',
                'error' => $validator->errors()
            ],200);
        }
        
        $email = Nominee::where('email',$request->email)->exists();
        if($email) {
            return response()->json([
                'message' => 'Email already exists'
                ]);
        }

        $allowedExtension = ['jpeg','jpg','png'];
        $image = $request->image;
        $extension = $image->getClientOriginalExtension();
        $check = in_array($extension, $allowedExtension);

        if ($check) {
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('/images'),$imageName);
        }

        DB::table('nominees')->insert([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'category_id' => $request->category,
            'country_of_origin' => $request->country_of_origin,
            'country_of_residence' => $request->country_of_residence,
            'image' => $imageName,
            'linkedIn' => $request->linkedin,
            'facebook' => $request->facebook,
            'instagam' => $request->instagram,
            'years_of_experience' => $request->years_of_experience,
        ]);

        // $nominee = new Nominee;
        // $nominee->fullname = $request->fullname;
        // $nominee->email = $request->email;
        // $nominee->category_id = $request->category;
        // $nominee->country_of_origin = $request->country_of_origin;
        // $nominee->country_of_residence = $request->country_of_residence;
        // $nominee->image = $imageName;
        // $nominee->linkedIn = $request->linkedin;
        // $nominee->facebook = $request->facebook;
        // $nominee->instagram = $request->instagram;
        // $nominee->years_of_experience = $request->years_of_experience;
        // $nominee->save();

        return response()->json([
            'message' => 'Nomination submitted successfully',
        ],200);
    }
    
    public function categories()
    {
       $categories = DB::table('categories')->orderBy('name','ASC')->get();
        return response()->json([
            'data' => $categories,
            'status' => 'success'
        ],200);
    }
    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
//login api
public function login(Request $request)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'phone' => 'required|string',
        'password' => 'required|string',
    ]);

    // Attempt to log in the user
    if (Auth::attempt(['phone' => $validatedData['phone'], 'password' => $validatedData['password']])) {
        $user = Auth::user();
        $token = $user->createToken('MyApp')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 200);
    } else {
        return response()->json(['message' => 'Invalid phone or password'], 401);
    }
}
//register api
public function register(Request $request)
{
    // Validate the incoming request data
    $validatedData = $request->validate([
        'full_name' => 'required|string',
        'phone' => 'required|string|unique:users',
        'college_name' => 'required|string',
        'hsc_exam_year' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:8',
        'package_status' => 'required|string',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Create a new user
    $user = User::create([
        'full_name' => $validatedData['full_name'],
        'phone' => $validatedData['phone'],
        'college_name' => $validatedData['college_name'],
        'hsc_exam_year' => $validatedData['hsc_exam_year'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
        'is_ban' => false,
        'balance' => '0',
        'package_status' => $validatedData['package_status'],
        'profile_image' => $request->hasFile('profile_image') ? $request->file('profile_image')->store('profile_images') : null,
    ]);

    // Refresh the user model to get the latest data from the database
    $user->refresh();

    $token = $user->createToken('MyApp')->plainTextToken;

    // Return the full user data in the response
    return response()->json(['user' => $user, 'token' => $token], 201);
}
  //logout
  public function logout(Request $request)
{
    $request->user()->tokens()->delete();

    return response()->json(['message' => 'Logged out successfully'], 200);
}
      
// api login  $ update

public function profileupdate(Request $request)
{
    $user = User::find($request->user()->id);

    if ($request->user()->email !== $request->email) {
        $validator = Validator::make($request->all(), [
            'email' => 'email|unique:users',
        ]);
    
        if ($validator->fails()) {
           
        }else{

            if ($request->email) {
                $user->email = $request->email;
            }
        }
   
  
    }if ($request->user()->phone_number !== $request->phone_number) {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'unique:users',
        ]);
    
        if ($validator->fails()) {
           
        }else{
            if($request->phone_number){
                $user->phone_number = $request->phone_number;
            } 
        }
   
  
    }
    if($request->full_name){
        $user->full_name = $request->full_name;
    }
 

    if ($request->hasFile('profile_image')) {
        $image = $request->file('profile_image');

                $imageName = $image->getClientOriginalName();
                $image->move(public_path('profileimage'), $imageName);
                $user->profile_image = "/profileimage/$imageName";
            }

    $user->save();

    
    return response()->json(['user' => $user, ], 200);
}      


public function updatePerformance(Request $request) {
    $performance = User::where('id', auth()->id())->first(); // Retrieve a single model instance

    // Update performance attributes
    $performance->total_answered += $request->total_answered;
    $performance->total_correct += $request->total_correct;
    $performance->total_incorrect += $request->total_incorrect + 1; // Increment total_incorrect by 1 and add request's total_incorrect
    $performance->total_marks += $request->total_marks; // Assuming total_marks is the attribute you want to add
   
    // Calculate accuracy percentage
    if ($performance->total_answered > 0) {
        $performance->accuracy_percentage = ($performance->total_correct / $performance->total_answered) * 100;
    } else {
        $performance->accuracy_percentage = 0; // If no questions are answered, accuracy is 0
    }

    $performance->save(); // Save the changes

    return response()->json([
        'user' => $performance,
    ], 201);
}


}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Rules\CheckOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class  AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required',
        ],$this->message());

        if ($validator->fails()) {
            return response()->api([], 1, $validator->errors()->first());
        }
        $credentials = $request->only('phone', 'password');
        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            $data['user'] = new UserResource($user);
            $data['token'] = $user->createToken('my-app-token')->plainTextToken;
            return response()->api($data,0,'تم تسجيل الدخول بنجاح');

        } else {

            return response()->api([], 1, __('auth.failed'));

        }//end of else

    }//end of login

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:users,phone|max:11|string',
            'password' => 'required|min:6',
            'type' => 'required'
        ], $this->message());

        if ($validator->fails()) {
            return response()->api([],1,$validator->errors()->first());
        }

        $user = User::create([
            'name' => $request->name,
            'type' => $request->type,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        $data['user'] = new UserResource($user);
        $data['token'] = $user->createToken('my-app-token')->plainTextToken;

        return response()->api($data,0,'تم تسجيل الدخول بنجاح');

    }//end of register

    public function user()
    {
        $data['user'] = new UserResource(auth()->user('sanctum'));
        return response()->api($data,0,'done');

    }// end of user

    public function changePassword(Request $request) {
        if (!(Hash::check($request->has('current-password'), Auth::user()->password))) {
            // The passwords matches

            return response()->api([], 1,'Your current password does not matches with the password.');// return redirect()->back()->with("error","Your current password does not matches with the password.");
        }

        if(strcmp($request->has('current-password'), $request->has('new-password')) == 0){
            // Current password and new password same

            return response()->api([], 1,'New Password cannot be same as your current password.');// return redirect()->back()->with("error","Your current password does not matches with the password.");
            // return redirect()->back()->with("error","New Password cannot be same as your current password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:8|confirmed',
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        /*$request->validate([
            'old_password' => ['required', new CheckOldPassword],
            'password' => 'required|confirmed'
        ]);

        $request->merge(['password' => bcrypt($request->password)]);

        auth()->user()->update($request->all());*/

        return response()->api([], 0,'your password changed successfully.');// return redirect()->back()->with("error","Your current password does not matches with the password.");

    }

    function message()
    {
        return [
            'name.required'=>'الاسم مطلوب',
            'password.min'=>'كلمة السر قصيرة',
            'password.required'=>'كلمة السر مطلوبة',
            'phone.required'=>'رقم المحمول مطلوب',
            'type.required'=>'نوع المستخدم مطلوب',
            'phone.unique'=>'رقم المحمول مستخدم مسبقا',
            'phone.max'=>'رقم المحمول مستخدم غير صالج',
            'phone.numeric'=>'رقم المحمول مستخدم غير صالج',
        ];
    }

}//end of controller

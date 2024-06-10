<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request){
        $user = User::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken('auth-token')->plainTextToken;
        return response()->json(["message" => "Ro'yxatdan muvaffaqqiyatli o'tdingiz", "token" => $token], 201);
    }

    public function login(LoginRequest $request){
        $login = [
            'username' => $request->username,
            'password' => $request->password,
        ];
        if (Auth::attempt($login)){
            $user = $request->user();
            $token = $user->createToken('auth-token')->plainTextToken;
            return response()->json(["token" => $token], 200);
        }else{
            return response()->json(["error"=> "Noto'g'ri ma'lumot kiritdingiz"], 401);
        }
    }

    public function getUsers(){
        return User::paginate(15);
    }

    public function searchUsers(){
        $search = request('search');

        return  User::where('active', true)
        ->whereAny([
            'username',
            'email',
            'phone',
            'full_name',
        ], 'like', "%$search%")
        ->paginate(15);

    }
}

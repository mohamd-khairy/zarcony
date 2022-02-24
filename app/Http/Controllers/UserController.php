<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function login(Request $request)
    {
        $v = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required",
        ]);

        if ($v->fails()) return $this->apiFailResponse($v->errors()->first(), 'validation error');

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $user->token = $user->createToken('user-token', [])->plainTextToken;
            return $this->apiSuccessResponse($user);
        }

        return $this->apiFailResponse('wrong credentials', 401);
    }

    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:32',
        ]);

        if ($v->fails()) return $this->apiFailResponse($v->errors()->first(), 'validation error');

        $user = User::create($request->only('name', 'email', 'password'));

        if ($user) {
            $user->token = $user->createToken('user-token', [])->plainTextToken;
            return $this->apiSuccessResponse($user);
        }

        return $this->apiFailResponse();
    }

    public function edit_profile($id, Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'nullable|string|min:2|max:100',
        ]);

        if ($v->fails()) return $this->apiFailResponse($v->errors()->first(), 'validation error');

        $user = User::find($id);
        if (!$user) {
            return $this->apiFailResponse('not found');
        }
        $user->update($request->only('name', 'email', 'password'));
        return $this->apiSuccessResponse($user, 'updated successfully');
    }

    public function users()
    {
        $users = User::query();
        if (request('user_id')) {
            $users = $users->where('id', request('user_id'))->first();
        } else {
            $users = $users->paginate(request('page_size', 10));
        }
        return $this->apiSuccessResponse($users);
    }

    public function delete($id)
    {
        if (Auth::user()->role != 'admin') {
            return $this->apiFailResponse('not have this permission');
        }

        $user = User::find($id);
        if (!$user) {
            return $this->apiFailResponse('not found');
        }
        $user->delete();
        return $this->apiSuccessResponse($user, 'deleted successfully');
    }
}

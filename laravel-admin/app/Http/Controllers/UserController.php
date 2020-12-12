<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() : LengthAwarePaginator
    {
        return User::paginate();
    }

    public function show(int $id) : User
    {
        return User::find($id);
    }

    public function store(UserCreateRequest $request) : Response
    {
        $user = User::create($request->only('first_name', 'last_name', 'email') + [
            'password' => Hash::make('12qwasZX')
        ]);

        return response($user, Response::HTTP_CREATED);
    }

    public function update(UserUpdateRequest $request, int $id) : Response
    {
        $user = User::find($id);

        $user->update($request->only('first_name', 'last_name', 'email'));

        return response($user, Response::HTTP_ACCEPTED);
    }

    public function destroy(int $id) : Response
    {
        User::destroy($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function user()
    {
        return Auth::user();
    }

    public function updateInfo(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return "User is not Auth!";
        }

        $user->update($request->only('first_name', 'last_name', 'email'));

        return response($user, Response::HTTP_ACCEPTED);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return "User is not Auth!";
        }

        $user->update($request->input('password'));

        return response($user, Response::HTTP_ACCEPTED);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('query')) {
            $query->where(function ($q) use ($request) {
                $q->where('firstName', 'like', '%' . $request->input('query') . '%')
                    ->orWhere('lastName', 'like', '%' . $request->input('query') . '%')
                    ->orWhere('email', 'like', '%' . $request->input('query') . '%');
            });
        }

        if ($request->has('sortBy') && $request->input('sortBy') === 'created_at') {
            $query->orderBy('created_at', 'desc');
        }

        $users = $query->paginate(10);

        return response()->json($users);
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['passwordHash'] = bcrypt($data['passwordHash']);
        $user = User::create($data);
        return response()->json($user, 201);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validated();
        if (isset($data['passwordHash'])) {
            $data['passwordHash'] = bcrypt($data['passwordHash']);
        }
        $user->update($data);
        return response()->json($user);
    }
    public function show($id)
    {
        $user = User::with('posts')->findOrFail($id);
        return response()->json($user);
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }
}

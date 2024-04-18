<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Lấy user list với paginate
        $query = User::query();

        // Query parameters
        if ($request->has('query')) {
            $query->where(function ($q) use ($request) {
                $q->where('firstName', 'like', '%' . $request->input('query') . '%')
                    ->orWhere('lastName', 'like', '%' . $request->input('query') . '%')
                    ->orWhere('email', 'like', '%' . $request->input('query') . '%');
            });
        }

        // Sort by created_at 
        if ($request->has('sortBy') && $request->input('sortBy') === 'created_at') {
            $query->orderBy('created_at', 'desc');
        }

        // Lấy user list với paginate
        $users = $query->paginate(10);

        return response()->json($users);
    }

    public function store(Request $request)
    {
        // Tạo mới user
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    public function show($id)
    {
        // Hiển thị thông tin chi tiết user
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        // Cập nhật thông tin user
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        // Xóa user
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }
}

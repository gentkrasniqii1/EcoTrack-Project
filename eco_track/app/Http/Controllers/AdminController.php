
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RecyclingReport;

class AdminController extends Controller
{
    public function countUsers()
    {
        return response()->json(['count' => User::count()]);
    }

    public function countReports()
    {
        return response()->json(['count' => RecyclingReport::count()]);
    }

    public function listUsers()
{
    return User::select('id', 'name', 'email', 'role')->get();
}

public function toggleUserRole($id)
{
    $user = User::findOrFail($id);
    $user->role = $user->role === 'admin' ? 'user' : 'admin';
    $user->save();

    return response()->json(['message' => 'Role updated']);
}

public function deleteUser($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return response()->json(['message' => 'User deleted']);
}

public function listReports()
{
    return RecyclingReport::with('user:id,name')->latest()->get();
}


}

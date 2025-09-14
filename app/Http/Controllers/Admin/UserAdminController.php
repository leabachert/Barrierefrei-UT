<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserAdminController extends Controller
{
    public function index()
    {
        return User::select('id', 'name', 'email', 'role')->get();
    }

    public function setRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:editor,admin'
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User konnte nicht gefunden werden'], 404);
        }

        $user->role = $request->role;
        $user->save();

        return response()->json(['message' => 'Rolle wurde erfolgreich geändert', 'user' => $user]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:editor,admin'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role']
        ]);

        return response()->json(['message' => 'Benutzer erstellt', 'user' => $user], 201);
    }

    public function remove(Request $request, $id)
    {
        $actor  = $request->user();
        $target = User::find($id);

        if ($target->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return response()->json(['message' => 'Der letzte Admin kann nicht entfernt werden'], 409);
        }

        if ($actor->id === $target->id) {
            return response()->json(['message' => 'Eigenes Konto kann nicht entfernt werden'], 409);
        }

        $target->delete();

        return response()->json(['message' => 'Nutzer gelöscht']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->get(['username', 'name', 'email']);

        return view('dashboard.user.index', [
            'title' => 'Daftar User',
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.user.create', [
            'title' => 'Tambah User',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'alpha_dash', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $validatedData['password'] = Hash::make($request->password);

        User::create($validatedData);
        return redirect()->route('user.index')->with('success', 'User berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dashboard.user.edit', [
            'title' => 'Perbarui User',
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
        ];

        if ($request->username != $user->username) {
            $rules['username'] = ['required', 'string', 'alpha_dash', 'max:255', 'unique:'.User::class];
        }

        if ($request->email != $user->email) {
            $rules['email'] = ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class];
        }

        $validatedData =  $request->validate($rules);

        $validatedData['password'] = Hash::make($request->password);

        $user->update($validatedData);
        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui!');
    }

    public function passwordUpdate(Request $request, User $user)
    {
        $rules = [
            'password' => ['required', 'confirmed', Password::defaults()],
        ];

        $validatedData =  $request->validate($rules);

        $validatedData['password'] = Hash::make($request->password);

        $user->update($validatedData);
        return redirect()->route('user.index')->with('success', 'Password User berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus!');
    }
}

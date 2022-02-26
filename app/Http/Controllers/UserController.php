<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'category' => 'required',
        ]);

        $user = null;

        // check kalau user tempat duduk atau bukan
        if ($request->category == 'tempat duduk') {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'category' => $request->category,
                'table_number' => $request->table_number,
            ]);
        }else{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'category' => $request->category,
            ]);
        }
        

        $user->assignRole($request->category);

        event(new Registered($user));

        session()->flash('success', 'The user was created');

        return redirect('/user');
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'required|string|confirmed|min:8',
            'category' => 'required',
        ]);

        $attr = $request->all();

        $attr['password'] = Hash::make($request->password);

        // check kalau user tempat duduk atau bukan
        if ($request->category == 'tempat duduk') {
            $user->update($attr);
        }else{
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'category' => $request->category,
            ]);
        }

        $user->syncRoles($request->category);

        session()->flash('success', 'The user was updated');

        return redirect('/user');
    }

    public function destroy(User $user)
    {
        // Menghapus row
        $user->delete();

        // Mengirim session
        session()->flash('success', 'The user was destroyed');
        return redirect('/user');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}

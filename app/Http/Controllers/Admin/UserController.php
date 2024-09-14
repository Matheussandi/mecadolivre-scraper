<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        User::create($request->validated());
        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        if (!$user = User::find($id)) {
            return redirect()
                ->route('users.index')
                ->with('message', 'User not found.');
        }

        return view('admin.users.show', compact('user'));

    }

    public function edit($id)
    {
        if (!$user = User::find($id)) {
            return redirect()
                ->route('users.index')
                ->with('message', 'User not found.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        if (!$user = User::find($id)) {
            return back()->with('message', 'User not found.');
        }

        $data = $request->only(['name', 'email']);

        if ($request->passowrd) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        if (Gate::allows('is-admin') === false) {
            return back()->with('message', 'You are not authorized to delete users.');
        }

        if (!$user = User::find($id)) {
            return redirect()
                ->route('users.index')
                ->with('message', 'User not found.');
        }

        if (Auth::user()->id === $user->id) {
            return back()->with('message', 'You cannot delete yourself.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}

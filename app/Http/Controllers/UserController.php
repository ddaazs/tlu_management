<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\Core\UserService;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userService->getPaginatedUsers();

        return view('page.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('page.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->only(['name', 'email', 'password', 'role']);

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            $validatedData['password'] = $user->password;
        }//end if
        $update = $this->userService->saveUser($user, $validatedData);

        if (!$update) {
            return back()->with('error', 'Update failed');
        }
        return redirect()->route('users.index')->with('success', 'Cập nhật tài khoản thành công.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->userService->destroy($user->id);

        return redirect()->route('users.index')->with('success', 'Tài khoản đã khóa vĩnh viễn.');
    }

    public function toggleStatus(User $user)
    {
        $this->userService->toggleStatus($user);

        return redirect()->route('users.index')->with('success', 'Cập nhật trạng thái tài khoản thành công.');
    }

}

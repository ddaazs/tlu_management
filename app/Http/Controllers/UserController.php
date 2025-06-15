<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Services\UserUpdateContext;
use App\Strategies\User\UpdateBasicInfoStrategy;
use App\Strategies\User\UpdatePasswordStrategy;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(8);
        return view('page.users.index', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('page.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user): RedirectResponse
    {
        $validatedData = $request->validated;
        if (!empty($validatedData['password'])) {
            $strategy = new UpdatePasswordStrategy();
        } else {
            $strategy = new UpdateBasicInfoStrategy();
        }

        $context = new UserUpdateContext($strategy);
        $success = $context->execute($validatedData, $user);

        if (!$success) {
            return back()->with('error', 'Update failed');
        }

        return redirect()->route('users.index')->with('success', 'Cập nhật tài khoản thành công.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->ban();
        return redirect()->route('users.index')->with('success', 'Tài khoản đã khóa vĩnh viễn.');
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        return redirect()->route('users.index')->with('success', 'Cập nhật trạng thái tài khoản thành công.');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
                'regex:/^[a-zA-Z0-9._%+-]+@tlu\.edu\.vn$/',
            ],
            'password' => 'nullable|min:6',
            'role' => 'required|in:quantri,giangvien,sinhvien',
        ], [
            'email.regex' => 'Email phải chứa @tlu.edu.vn',
        ]);

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            $validatedData['password'] = $user->password;
        }
        
        if(!$user->update($validatedData)){
            return back()->with('error', 'Update failed');
        }
        else return redirect()->route('users.index')->with('success', 'Cập nhật tài khoản thành công.');

    
        // $user->name = $request->name;
        // $user->email = $request->email; // Tên đăng nhập là email
    


    
        // $user->role = $request->role;
        // $user->save();

        // return redirect()->route('users.index')->with('success', 'Cập nhật tài khoản thành công.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->ban();
        return redirect()->route('users.index')->with('success', 'Tài khoản đã khóa vĩnh viễn.');
    }
    
    public function toggleStatus(User $user)
    {
        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        return redirect()->route('users.index')->with('success', 'Cập nhật trạng thái tài khoản thành công.');
    }

}

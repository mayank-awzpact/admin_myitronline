<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{

    public function index(Request $request)
{
    $query = DB::table('users')->where('is_deleted', 0); 

    if ($request->has('search')) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'LIKE', '%' . $request->search . '%')
              ->orWhere('email', 'LIKE', '%' . $request->search . '%');
        });
    }

    $users = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('users.index', compact('users'));
}



    public function create()
    {
        return view('users.create');
    }


    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Insert user into the database
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('users.index')->with('success', 'User added successfully!');
    }


    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $user = DB::table('users')->where('id', $id)->first();

        return view('users.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {
        $id = Crypt::decryptString($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        DB::table('users')->where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'updated_at' => now(),
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $id = Crypt::decryptString($id); 
    
        DB::table('users')->where('id', $id)->update([
            'is_deleted' => 1,
            'updated_at' => now(),
        ]);
    
        return redirect()->route('users.index')->with('error', 'User deleted successfully!');
    }

    public function view_trash(Request $request)
    {
        $query = DB::table('users')->where('is_deleted', 1); 
    
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('email', 'LIKE', '%' . $request->search . '%');
            });
        }
    
        $users = $query->orderBy('updated_at', 'desc')->paginate(10);
    
        return view('users.trash', compact('users'));
    }
    
    public function restore($id)
{
    $id = Crypt::decryptString($id);

    DB::table('users')->where('id', $id)->update([
        'is_deleted' => 0,
        'updated_at' => now(),
    ]);

    return redirect()->route('users.index')->with('success', 'User restored successfully!');
}

    
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // For hashing passwords
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportUser;

class UserController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('users.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // Validate the request data.
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'mobile'   => 'nullable|string|max:20',
            'date'     => 'nullable|date',
            'role'     => 'required|in:Admin,User',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Handle file upload if an image is provided.
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $imageName  = time().'_'.$image->getClientOriginalName();
            $destination= public_path('/uploads/images');
            $image->move($destination, $imageName);
            $imagePath  = 'uploads/images/'.$imageName;
        }

        // Create new user
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // hash the password
            'mobile'   => $request->mobile,
            'date'     => $request->date,
            'role'     => $request->role,
            'image'    => $imagePath,
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'User created successfully.');
    }

    // Display the specified resource.
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, $id)
    {
        // Validate the request.
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => "required|email|unique:users,email,{$id}",
            'mobile'   => 'nullable|string|max:20',
            'date'     => 'nullable|date',
            'role'     => 'required|in:Admin,User',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $user = User::findOrFail($id);

        // Handle file upload for the image if provided.
        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $imageName  = time().'_'.$image->getClientOriginalName();
            $destination= public_path('/uploads/images');
            $image->move($destination, $imageName);
            $user->image = 'uploads/images/'.$imageName;
        }

        // Update user fields.
        $user->name   = $request->name;
        $user->email  = $request->email;
        // If password is filled, update it.
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->mobile = $request->mobile;
        $user->date   = $request->date;
        $user->role   = $request->role;
        $user->save();

        return redirect()->route('users.index')
                         ->with('success', 'User updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // Optionally delete the image file if exists.
        if ($user->image && file_exists(public_path($user->image))) {
            unlink(public_path($user->image));
        }
        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'User deleted successfully.');
    }

    public function export(Request $request)
    {
        return Excel::download(new ExportUser(), 'User-'.now()->setTimezone('Asia/Kolkata')->format('d-M-Y-H-i-s').'.xlsx');
    }
}

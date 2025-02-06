<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportUser;
use Session;

class UserController extends Controller
{
    public function index()
    {   
        // Session::flush();
        // Session::regenerate(true);

        // $userSessionArray = [];
        $userSessionArray = User::sessionAllUsers();
        // dd($userSessionArray);

        return view('users.index', compact('userSessionArray'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {

        $userSessionArray = session('userSessionArray');

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'mobile'   => 'nullable|string|max:20',
            'date'     => 'nullable|date',
            'role'     => 'required|in:Admin,User',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $imageName  = time().'_'.$image->getClientOriginalName();
            $destination= public_path('/uploads/images');
            $image->move($destination, $imageName);
            $imagePath  = 'uploads/images/'.$imageName;
        }

        $uniqid = uniqid();

        $newUserArr = [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'mobile'   => $request->mobile,
            'date'     => $request->date,
            'role'     => $request->role,
            'image'    => $imagePath,
            'id'        => $uniqid,
        ];

        $userSessionArray[$uniqid] = (object) $newUserArr;
        session(['userSessionArray' => $userSessionArray]);

        return redirect()->route('users.index')
                         ->with('success', 'User created successfully.');
    }

    public function show($id)
    {   
        $user = User::sessionFindUser($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::sessionFindUser($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => "required|email|unique:users,email,{$id}",
            'mobile'   => 'nullable|string|max:20',
            'date'     => 'nullable|date',
            'role'     => 'required|in:Admin,User',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $user = User::sessionFindUser($id);

        if ($request->hasFile('image')) {
            $image      = $request->file('image');
            $imageName  = time().'_'.$image->getClientOriginalName();
            $destination= public_path('/uploads/images');
            $image->move($destination, $imageName);
            $user->image = 'uploads/images/'.$imageName;
        }

        $user->name   = $request->name;
        $user->email  = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->mobile = $request->mobile;
        $user->date   = $request->date;
        $user->role   = $request->role;
        
        $userSessionArray[$id] = $user;
        session(['userSessionArray' => $userSessionArray]);

        return redirect()->route('users.index')
                         ->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->image && file_exists(public_path($user->image))) {
            unlink(public_path($user->image));
        }
        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'User deleted successfully.');
    }
    
}

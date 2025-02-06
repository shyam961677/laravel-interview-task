@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h2>User List</h2>
        <div class="flex">
            <a class="btn btn-primary" href="{{ route('users.create') }}">Create New User</a>
            <a class="btn btn-secondary" href="{{ route('dbusers.export') }}">Export Users</a>
            <a class="btn btn-info" href="{{ route('dbusers.import') }}">Import Users</a>
            <a class="btn btn-info" href="{{ route('dbusers.index') }}">Show DB Users</a>
        </div>
    </div>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Date</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($userSessionArray) && !empty($userSessionArray))
                @foreach ($userSessionArray as $key => $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            @if($user->image)
                                <img src="{{ asset($user->image) }}" alt="User Image" width="50">
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile }}</td>
                        <td>{{ $user->date }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <a class="btn btn-info btn-sm" href="{{ route('users.show', $user->id) }}">Show</a>
                            <a class="btn btn-warning btn-sm" href="{{ route('users.edit', $user->id) }}">Edit</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure to delete?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>                        
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="8" class="text-center">
                        <a class="btn btn-primary" href="{{ route('users.final-submit') }}">Final Submit</a>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection

@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="admin-users">
    <h1>User Management</h1>
    
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Roles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->type }}</td>
                <td>
                    @foreach($user->roles as $role)
                    <span class="role-badge">{{ $role->name }}</span>
                    @endforeach
                </td>
                <td>
                    <form action="{{ route('admin.users.update-roles', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="roles[]" multiple>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                            @endforeach
                        </select>
                        <button type="submit">Update Roles</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    {{ $users->links() }}
</div>
@endsection
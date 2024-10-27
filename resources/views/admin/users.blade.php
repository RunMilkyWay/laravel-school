@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Manage Users</h1>

        <!-- Success and Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Create New User Button -->
        <div class="d-flex gap-2 mb-3">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
            <button class="btn btn-success" onclick="openCreateUserModal()" data-bs-toggle="modal" data-bs-target="#userModal">
                Create New User
            </button>
        </div>

        <!-- Users Table -->
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->type_id == 1 ? 'User' : ($user->type_id == 2 ? 'Worker' : 'Admin') }}</td>
                    <td class="d-flex gap-2">
                        <button class="btn btn-primary btn-sm" onclick="fillEditForm({{ $user }})" data-bs-toggle="modal" data-bs-target="#userModal">Edit</button>
                        @if($user->type_id != 3)
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- User Modal -->
        <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="form-title">Create New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="user-form" action="{{ route('admin.users.store') }}" method="POST">
                            @csrf
                            <input type="hidden" id="user-id" name="user_id">

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control">
                                <small>Leave blank to keep the current password when editing</small>
                            </div>

                            <div class="mb-3">
                                <label for="type_id" class="form-label">Role</label>
                                <select id="type_id" name="type_id" class="form-control" required>
                                    <option value="1">User</option>
                                    <option value="2">Worker</option>
                                    <option value="3">Admin</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary" id="form-submit">Create User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript for Modal Control -->
        <script>
            function openCreateUserModal() {
                document.getElementById('form-title').innerText = 'Create New User';
                document.getElementById('user-form').reset();
                document.getElementById('user-id').value = '';
                document.getElementById('user-form').action = `{{ route('admin.users.store') }}`;
                document.getElementById('form-submit').innerText = 'Create User';
                const methodInput = document.querySelector('#user-form input[name="_method"]');
                if (methodInput) methodInput.remove();
            }

            function fillEditForm(user) {
                document.getElementById('form-title').innerText = 'Edit User';
                document.getElementById('user-id').value = user.id;
                document.getElementById('name').value = user.name;
                document.getElementById('email').value = user.email;
                document.getElementById('type_id').value = user.type_id;
                document.getElementById('form-submit').innerText = 'Update User';
                document.getElementById('user-form').action = `{{ url('admin/users') }}/${user.id}`;
                document.getElementById('user-form').method = 'POST';

                const existingMethodInput = document.querySelector('#user-form input[name="_method"]');
                if (existingMethodInput) existingMethodInput.remove();

                const methodInput = document.createElement('input');
                methodInput.setAttribute('type', 'hidden');
                methodInput.setAttribute('name', '_method');
                methodInput.setAttribute('value', 'PUT');
                document.getElementById('user-form').appendChild(methodInput);
            }
        </script>
    </div>
@endsection

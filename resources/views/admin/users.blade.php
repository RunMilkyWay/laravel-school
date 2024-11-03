@extends('layouts.app')

@section('content')
    <div data-aos="fade">
    <div class="container">
        <h1 class="mb-4">{{ __('messages.manage_users') }}</h1>

        <!-- Success and Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Create New User Button -->
        <div class="d-flex gap-2 mb-3">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">{{ __('messages.back_to_dashboard') }}</a>
            <button class="btn btn-success" onclick="openCreateUserModal()" data-bs-toggle="modal" data-bs-target="#userModal">
                {{ __('messages.create_new_user') }}
            </button>
        </div>

        <!-- Users Table -->
        <table class="table table-striped">
            <thead>
            <tr>
                <th>{{ __('messages.name') }}</th>
                <th>{{ __('messages.email') }}</th>
                <th>{{ __('messages.role') }}</th>
                <th>{{ __('messages.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->type_id == 1 ? __('messages.user') : ($user->type_id == 2 ? __('messages.worker') : __('messages.admin')) }}</td>
                    <td class="d-flex gap-2">
                        <button class="btn btn-primary btn-sm" onclick="fillEditForm({{ $user }})" data-bs-toggle="modal" data-bs-target="#userModal">{{ __('messages.edit') }}</button>
                        @if($user->type_id != 3)
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('messages.confirm_delete_user') }}')">{{ __('messages.delete') }}</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </div>

        <!-- User Modal -->
        <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="form-title">{{ __('messages.create_new_user') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('messages.close') }}"></button>
                    </div>
                    <div class="modal-body">
                        <form id="user-form" action="{{ route('admin.users.store') }}" method="POST">
                            @csrf
                            <input type="hidden" id="user-id" name="user_id">

                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('messages.name') }}</label>
                                <input type="text" id="name" name="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('messages.email') }}</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('messages.password') }}</label>
                                <input type="password" id="password" name="password" class="form-control">
                                <small>{{ __('messages.password_note') }}</small>
                            </div>

                            <div class="mb-3">
                                <label for="type_id" class="form-label">{{ __('messages.role') }}</label>
                                <select id="type_id" name="type_id" class="form-control" required>
                                    <option value="1">{{ __('messages.user') }}</option>
                                    <option value="2">{{ __('messages.worker') }}</option>
                                    <option value="3">{{ __('messages.admin') }}</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary" id="form-submit">{{ __('messages.create_user') }}</button>
                        </form>
                    </div>
                </div>
            </div>

        <!-- JavaScript for Modal Control -->
        <script>
            const storeRoute = `{{ route('admin.users.store') }}`;
            const updateRoute = `{{ url('admin/users') }}`;
            const formTitleTranslations = {
                create: "{{ __('messages.create_new_user') }}",
                createUser: "{{ __('messages.create_user') }}",
                edit: "{{ __('messages.edit_user') }}",
                updateUser: "{{ __('messages.update_user') }}"
            };
        </script>
    </div>
@endsection

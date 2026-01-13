@extends('backendPage.layouts.master')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">User Approval Dashboard</h2>
        <div class="card">
            <div class="card-header">Pending Users</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Approve</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingUsers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.users.approve', $user->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

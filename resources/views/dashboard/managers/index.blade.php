<x-app-layout>
    <div class="container">
        <h2 class="mb-4">Your Managers</h2>
        <a href="{{ route('managers.create') }}" class="btn btn-primary mb-3">Add New Manager</a>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($managers as $manager)
                    <tr>
                        <td>{{ $manager->name }}</td>
                        <td>{{ $manager->email }}</td>
                        <td>{{ $manager->created_at->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No managers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="container">
        <h2 class="mb-4">Pending Add Client Requests</h2>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <a href="{{ route('manager.addclient.request.create') }}" class="btn btn-primary mb-3">Request New Client</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Number</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Requested At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingAddclients as $approval)
                    @php $data = json_decode($approval->new_data, true); @endphp
                    <tr>
                        <td>{{ $data['name'] ?? '' }}</td>
                        <td>{{ $data['email'] ?? '' }}</td>
                        <td>{{ $data['number'] ?? '' }}</td>
                        <td>{{ $data['address'] ?? '' }}</td>
                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                        <td>{{ $approval->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No pending requests.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>

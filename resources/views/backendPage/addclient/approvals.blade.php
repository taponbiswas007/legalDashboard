<x-app-layout>
    <div class="container py-4">
        <h2 class="mb-4">Pending Client Approvals</h2>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Manager</th>
                    <th>Client Name</th>
                    <th>Email</th>
                    <th>Number</th>
                    <th>Address</th>
                    <th>Requested At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($approvals as $approval)
                    @php $data = json_decode($approval->new_data, true); @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $approval->manager ? $approval->manager->name : 'N/A' }}</td>
                        <td>{{ $data['name'] ?? '' }}</td>
                        <td>{{ $data['email'] ?? '' }}</td>
                        <td>{{ $data['number'] ?? '' }}</td>
                        <td>{{ $data['address'] ?? '' }}</td>
                        <td>{{ $approval->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <form action="{{ route('addclient.approvals.finalize', $approval->id) }}" method="POST"
                                style="display:inline-block">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                            </form>
                            <form action="{{ route('addclient.approvals.reject', $approval->id) }}" method="POST"
                                style="display:inline-block">
                                @csrf
                                <input type="text" name="rejection_note"
                                    class="form-control form-control-sm d-inline-block w-auto"
                                    placeholder="Rejection note" required style="width: 140px; margin-bottom: 4px;">
                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No pending requests</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="container py-4">
        <h2 class="mb-4">Rejected Client Requests</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Email</th>
                    <th>Number</th>
                    <th>Address</th>
                    <th>Rejected At</th>
                    <th>Rejection Note</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rejected as $approval)
                    @php $data = json_decode($approval->new_data, true); @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data['name'] ?? '' }}</td>
                        <td>{{ $data['email'] ?? '' }}</td>
                        <td>{{ $data['number'] ?? '' }}</td>
                        <td>{{ $data['address'] ?? '' }}</td>
                        <td>{{ $approval->updated_at->format('d M Y H:i') }}</td>
                        <td>{{ $approval->rejection_note }}</td>
                        <td>
                            <a href="{{ route('manager.addclient.request.edit', $approval->id) }}"
                                class="btn btn-primary btn-sm">Edit &amp; Resubmit</a>
                            <form action="{{ route('manager.addclient.request.destroy', $approval->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this rejected request?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No rejected requests</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>

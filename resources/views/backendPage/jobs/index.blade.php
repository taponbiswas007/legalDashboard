<x-app-layout>
    <div class="py-4 px-1 body_area">
        <div class="card shadow rounded border-0 mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <!-- Breadcrumb Section -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">
                                    <i class="fa-solid fa-house"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Job Circulars
                            </li>
                        </ol>
                    </nav>
                    <a href="{{ route('jobs.create') }}" class="btn btn-primary addBtn">
                        <i class="fa-solid fa-plus"></i> Post New Job
                    </a>
                </div>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow rounded border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Title</th>
                                <th>Location</th>
                                <th>Job Type</th>
                                <th>Deadline</th>
                                <th>Applications</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jobs as $job)
                                <tr>
                                    <td>
                                        <strong>{{ $job->title }}</strong>
                                    </td>
                                    <td>{{ $job->location ?? 'N/A' }}</td>
                                    <td>
                                        @if ($job->job_type)
                                            <span class="badge bg-info">{{ $job->job_type }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $job->deadline->format('d-M-Y') }}</td>
                                    <td>
                                        <a href="{{ route('jobs.applications', $job->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            {{ $job->total_applications }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($job->is_published && $job->deadline >= now())
                                            <span class="badge bg-success">Active</span>
                                        @elseif($job->is_published)
                                            <span class="badge bg-warning">Closed</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-sm btn-info"
                                                title="View">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-sm btn-warning"
                                                title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="deleteJob({{ $job->id }})" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        No jobs posted yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $jobs->links() }}
        </div>
    </div>

    <script>
        function deleteJob(jobId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This job and all applications will be deleted!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ url('admin/jobs') }}/${jobId}`;
                    form.innerHTML = `@csrf @method('DELETE')`;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
</x-app-layout>

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
                            <li class="breadcrumb-item">
                                <a href="{{ route('jobs.index') }}" class="text-decoration-none text-dark">
                                    Job Circulars
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Applications for {{ $job->title }}
                            </li>
                        </ol>
                    </nav>
                    <a href="{{ route('jobs.index') }}" class="btn btn-primary addBtn">
                        <i class="fa-solid fa-arrow-left"></i> Back to Jobs
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
            <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fa-solid fa-users text-primary"></i> Total Applications:
                    <span class="badge bg-primary ms-2">{{ $job->total_applications }}</span>
                </h5>
            </div>

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th><i class="fa-solid fa-user"></i> Name</th>
                            <th><i class="fa-solid fa-envelope"></i> Email</th>
                            <th><i class="fa-solid fa-phone"></i> Phone</th>
                            <th><i class="fa-solid fa-file"></i> CV</th>
                            <th><i class="fa-solid fa-flag"></i> Status</th>
                            <th><i class="fa-solid fa-calendar"></i> Applied</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $app)
                            <tr>
                                <td><strong>{{ $app->name }}</strong></td>
                                <td>
                                    <a href="mailto:{{ $app->email }}"
                                        class="text-decoration-none">{{ $app->email }}</a>
                                </td>
                                <td>
                                    <a href="tel:{{ $app->phone }}"
                                        class="text-decoration-none">{{ $app->phone }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('applications.download.cv', $app->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-download"></i> Download
                                    </a>
                                </td>
                                <td>
                                    <form action="{{ route('applications.update.status', $app->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-select form-select-sm rounded"
                                            onchange="this.form.submit()">
                                            <option value="pending" {{ $app->status == 'pending' ? 'selected' : '' }}>
                                                <i class="fa-solid fa-hourglass-start"></i> Pending
                                            </option>
                                            <option value="reviewed"
                                                {{ $app->status == 'reviewed' ? 'selected' : '' }}>
                                                <i class="fa-solid fa-eye"></i> Reviewed
                                            </option>
                                            <option value="shortlisted"
                                                {{ $app->status == 'shortlisted' ? 'selected' : '' }}>
                                                <i class="fa-solid fa-star"></i> Shortlisted
                                            </option>
                                            <option value="rejected"
                                                {{ $app->status == 'rejected' ? 'selected' : '' }}>
                                                <i class="fa-solid fa-xmark"></i> Rejected
                                            </option>
                                        </select>
                                    </form>
                                </td>
                                <td>{{ $app->created_at->format('d M Y') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#applicationModal{{ $app->id }}" title="View Details">
                                        <i class="fa-solid fa-eye"></i> View
                                    </button>
                                </td>
                            </tr>

                            <!-- Application Modal -->
                            <div class="modal fade" id="applicationModal{{ $app->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light border-bottom">
                                            <h5 class="modal-title"><i class="fa-solid fa-file-lines text-primary"></i>
                                                Application Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-4">
                                                <h6 class="text-primary mb-3"><i class="fa-solid fa-user-circle"></i>
                                                    Applicant Information</h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p class="mb-2"><strong>Name:</strong></p>
                                                        <p class="text-muted">{{ $app->name }}</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="mb-2"><strong>Email:</strong></p>
                                                        <p><a href="mailto:{{ $app->email }}"
                                                                class="text-decoration-none">{{ $app->email }}</a>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="mb-2"><strong>Phone:</strong></p>
                                                        <p><a href="tel:{{ $app->phone }}"
                                                                class="text-decoration-none">{{ $app->phone }}</a>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="mb-2"><strong>Applied On:</strong></p>
                                                        <p class="text-muted">
                                                            {{ $app->created_at->format('d M Y H:i') }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            @if ($app->cover_letter)
                                                <div class="mb-4">
                                                    <h6 class="text-primary mb-2"><i class="fa-solid fa-pen-fancy"></i>
                                                        Cover Letter</h6>
                                                    <div
                                                        class="p-3 bg-light rounded border-start border-primary border-3">
                                                        {{ $app->cover_letter }}
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="mb-3">
                                                <h6 class="text-primary mb-2"><i class="fa-solid fa-note-sticky"></i>
                                                    Admin Notes</h6>
                                                <form action="{{ route('applications.update.status', $app->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <textarea name="admin_notes" class="form-control" rows="4" placeholder="Add notes about this application...">{{ $app->admin_notes }}</textarea>
                                                    <button type="submit" class="btn btn-sm btn-primary mt-3">
                                                        <i class="fa-solid fa-save"></i> Save Notes
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="fa-solid fa-inbox"></i> No applications yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $applications->links() }}
        </div>
    </div>
</x-app-layout>

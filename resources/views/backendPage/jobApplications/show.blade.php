<x-app-layout>
    <div class="py-4 px-1 body_area">
        <div class="card shadow rounded border-0 mb-3">
            <div class="card-body">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">
                                <i class="fa-solid fa-house"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('notifications.all') }}" class="text-decoration-none text-dark">
                                Notifications
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Job Application Details
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card shadow rounded border-0">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-briefcase"></i> Job Application for: {{ $application->job->title }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Applicant Information -->
                    <div class="col-md-6 mb-4">
                        <h6 class="text-primary border-bottom pb-2">
                            <i class="fas fa-user"></i> Applicant Information
                        </h6>
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold" style="width: 150px;">Name:</td>
                                <td>{{ $application->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Email:</td>
                                <td>
                                    <a href="mailto:{{ $application->email }}">{{ $application->email }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Phone:</td>
                                <td>
                                    <a href="tel:{{ $application->phone }}">{{ $application->phone }}</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Applied On:</td>
                                <td>{{ $application->created_at->timezone('Asia/Dhaka')->format('M d, Y \a\t h:i A') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Status:</td>
                                <td>
                                    @if ($application->status === 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($application->status === 'shortlisted')
                                        <span class="badge bg-info">Shortlisted</span>
                                    @elseif($application->status === 'accepted')
                                        <span class="badge bg-success">Accepted</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Job Information -->
                    <div class="col-md-6 mb-4">
                        <h6 class="text-primary border-bottom pb-2">
                            <i class="fas fa-briefcase"></i> Job Information
                        </h6>
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold" style="width: 150px;">Position:</td>
                                <td>{{ $application->job->title }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Vacancy:</td>
                                <td>{{ $application->job->vacancy }} positions</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Deadline:</td>
                                <td>{{ $application->job->deadline->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Total Applications:</td>
                                <td>{{ $application->job->total_applications }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Cover Letter -->
                @if ($application->cover_letter)
                    <div class="mb-4">
                        <h6 class="text-primary border-bottom pb-2">
                            <i class="fas fa-file-alt"></i> Cover Letter
                        </h6>
                        <div class="bg-light p-3 rounded">
                            {{ $application->cover_letter }}
                        </div>
                    </div>
                @endif

                <!-- CV/Resume -->
                <div class="mb-4">
                    <h6 class="text-primary border-bottom pb-2">
                        <i class="fas fa-file-pdf"></i> CV/Resume
                    </h6>
                    @if ($application->cv_file)
                        <a href="{{ asset('uploads/cvs/' . $application->cv_file) }}" class="btn btn-outline-primary"
                            target="_blank">
                            <i class="fas fa-download"></i> Download CV
                        </a>
                    @else
                        <p class="text-muted">No CV uploaded</p>
                    @endif
                </div>

                <!-- Admin Notes -->
                <div class="mb-4">
                    <h6 class="text-primary border-bottom pb-2">
                        <i class="fas fa-sticky-note"></i> Admin Notes
                    </h6>
                    <form action="{{ route('job.applications.updateNotes', $application->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <textarea name="admin_notes" class="form-control mb-2" rows="3" placeholder="Add notes about this application...">{{ $application->admin_notes }}</textarea>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Notes
                        </button>
                    </form>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('notifications.all') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Notifications
                    </a>
                    <a href="mailto:{{ $application->email }}" class="btn btn-info">
                        <i class="fas fa-envelope"></i> Email Applicant
                    </a>
                    <a href="tel:{{ $application->phone }}" class="btn btn-success">
                        <i class="fas fa-phone"></i> Call Applicant
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

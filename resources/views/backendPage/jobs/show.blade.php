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
                                {{ $job->title }}
                            </li>
                        </ol>
                    </nav>
                    <div class="d-flex gap-2">
                        <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-warning addBtn">
                            <i class="fa-solid fa-pen"></i> Edit
                        </a>
                        <a href="{{ route('jobs.index') }}" class="btn btn-secondary addBtn">Back</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow rounded border-0 mb-3">
                    <div class="card-header bg-light border-bottom">
                        <h5 class="mb-0">Job Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="mb-3">
                                    <strong><i class="fa-solid fa-briefcase text-primary"></i> Job Type:</strong><br>
                                    {{ $job->job_type ?? 'N/A' }}
                                </p>
                                <p class="mb-3">
                                    <strong><i class="fa-solid fa-map-location-dot text-primary"></i>
                                        Location:</strong><br>
                                    {{ $job->location ?? 'N/A' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-3">
                                    <strong><i class="fa-solid fa-money-bill text-primary"></i> Salary
                                        Range:</strong><br>
                                    {{ $job->salary_range ?? 'N/A' }}
                                </p>
                                <p class="mb-3">
                                    <strong><i class="fa-solid fa-calendar-days text-primary"></i>
                                        Deadline:</strong><br>
                                    {{ $job->deadline->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                        <hr>
                        <h6><i class="fa-solid fa-align-left text-primary"></i> Description:</h6>
                        <div class="job-description p-3 bg-light rounded">
                            {!! $job->description !!}
                        </div>
                    </div>
                </div>

                @if ($job->pdf_file)
                    <div class="card shadow rounded border-0 mb-3">
                        <div class="card-header bg-light border-bottom">
                            <h5 class="mb-0"><i class="fa-solid fa-file-pdf text-danger"></i> Job Circular</h5>
                        </div>
                        <div class="card-body">
                            <a href="{{ asset('uploads/job_circulars/' . $job->pdf_file) }}"
                                class="btn btn-outline-primary" target="_blank">
                                <i class="fa-solid fa-download"></i> Download Circular (PDF)
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card shadow rounded border-0">
                    <div class="card-header bg-light border-bottom">
                        <h5 class="mb-0"><i class="fa-solid fa-chart-bar text-primary"></i> Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 p-3 bg-light rounded text-center">
                            <h6 class="text-muted mb-2">Total Applications</h6>
                            <h2 class="text-primary mb-0">{{ $job->total_applications }}</h2>
                        </div>
                        <a href="{{ route('jobs.applications', $job->id) }}" class="btn btn-primary w-100 mb-3">
                            <i class="fa-solid fa-users"></i> View Applications
                        </a>
                        <hr>
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Publication Status</h6>
                            @if ($job->is_published && $job->deadline >= now())
                                <span class="badge bg-success p-2" style="font-size: 0.85rem;">
                                    <i class="fa-solid fa-circle-check"></i> Active
                                </span>
                            @elseif($job->is_published)
                                <span class="badge bg-warning p-2" style="font-size: 0.85rem;">
                                    <i class="fa-solid fa-clock"></i> Closed
                                </span>
                            @else
                                <span class="badge bg-secondary p-2" style="font-size: 0.85rem;">
                                    <i class="fa-solid fa-file"></i> Draft
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

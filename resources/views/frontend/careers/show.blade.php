@extends('frontendLayouts.master')

@section('title', $job->title . ' - Job Opening at SK Sharif & Associates')
@section('meta_description', 'Job Opening: ' . $job->title . ' at SK Sharif & Associates. Deadline: ' .
    $job->deadline->format('d M Y') . '. Apply now to join our team.')
@section('meta_keywords', 'job opening, ' . $job->title . ', ' . ($job->location ?? 'Bangladesh') . ', legal job, apply
    now')

@section('content')
    <!-- ==========Banner area start=========== -->
    <div class="banner">
        <div class="banner-content">
            <h1>{{ $job->title }}</h1>
            <p>Join our team and make an impact</p>
        </div>
    </div>
    <!-- ==========Banner area end=========== -->

    <!-- ==========Job Details Section Start=========== -->
    <div class="service">
        <div class="container">
            <div class="row g-4">
                <!-- Left Column - Job Details -->
                <div class="col-lg-8">
                    <!-- Job Meta Information -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="row g-3">
                                @if ($job->location)
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="card-icon">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted">Location</small>
                                                <p class="mb-0 fw-bold">{{ $job->location }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($job->job_type)
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="card-icon">
                                                <i class="fas fa-briefcase"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted">Job Type</small>
                                                <p class="mb-0 fw-bold">{{ $job->job_type }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($job->salary_range)
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="card-icon">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted">Salary Range</small>
                                                <p class="mb-0 fw-bold">{{ $job->salary_range }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="card-icon">
                                            <i class="fas fa-calendar-days"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted">Deadline</small>
                                            <p class="mb-0 fw-bold">{{ $job->deadline->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Description -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class="fas fa-align-left"></i> Job Description
                            </h5>
                            <div class="job-description">
                                {!! $job->description !!}
                            </div>
                        </div>
                    </div>

                    <!-- Job Circular PDF -->
                    @if ($job->pdf_file)
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="card-title mb-3">
                                    <i class="fas fa-file-pdf text-danger"></i> Job Circular
                                </h5>
                                <p class="text-muted mb-3">Download the complete job circular for more details:</p>
                                <a href="{{ route('careers.download.circular', $job->id) }}"
                                    class="btn btn-outline-primary">
                                    <i class="fas fa-download"></i> Download PDF Circular
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column - Sidebar -->
                <div class="col-lg-4">
                    <!-- Apply Widget -->
                    <div class="card border-0 shadow-sm mb-4 position-sticky" style="top: 100px;">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-check-circle text-success"></i> Ready to Apply?
                            </h5>
                            <button class="btn btn-primary w-100 mb-3" data-bs-toggle="modal"
                                data-bs-target="#applicationModal">
                                <i class="fas fa-paper-plane"></i> Apply Now
                            </button>
                            <p class="text-muted small mb-0">
                                <i class="fas fa-info-circle"></i> Please prepare your CV before applying
                            </p>
                        </div>
                    </div>

                    <!-- Share Widget -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-share-alt"></i> Share This Job
                            </h5>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                    target="_blank" class="btn btn-sm btn-outline-primary" title="Share on Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($job->title) }}"
                                    target="_blank" class="btn btn-sm btn-outline-primary" title="Share on Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}"
                                    target="_blank" class="btn btn-sm btn-outline-primary" title="Share on LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($job->title . ' - ' . request()->url()) }}"
                                    target="_blank" class="btn btn-sm btn-outline-primary" title="Share on WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-secondary" onclick="copyLink()" title="Copy Link">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Widget -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-users"></i> Applications
                            </h5>
                            <div class="text-center">
                                <h2 class="text-primary mb-2">{{ $job->total_applications }}</h2>
                                <p class="text-muted mb-0">Total Applications Received</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Widget -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-headset"></i> Need Help?
                            </h5>
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Email:</small>
                                <a href="mailto:advocatesnilroy@gmail.com" class="text-decoration-none">
                                    <i class="fas fa-envelope"></i> advocatesnilroy@gmail.com
                                </a>
                            </div>
                            <div>
                                <small class="text-muted d-block mb-1">Phone:</small>
                                <a href="tel:+8801234567890" class="text-decoration-none">
                                    <i class="fas fa-phone"></i> +880 1740-106009
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('careers.index') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left"></i> Back to All Jobs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ==========Job Details Section End=========== -->

    <!-- Application Modal -->
    <div class="modal fade" id="applicationModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title">
                        <i class="fas fa-file-alt"></i> Apply for: {{ $job->title }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('careers.apply', $job->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Enter your full name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" placeholder="your.email@example.com" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number <span
                                    class="text-danger">*</span></label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                id="phone" name="phone" placeholder="+880 1234567890" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cover_letter" class="form-label">Cover Letter (Optional)</label>
                            <textarea class="form-control @error('cover_letter') is-invalid @enderror" id="cover_letter" name="cover_letter"
                                rows="4" placeholder="Tell us why you're interested in this position..."></textarea>
                            @error('cover_letter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cv_file" class="form-label">Upload Your CV <span
                                    class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('cv_file') is-invalid @enderror"
                                id="cv_file" name="cv_file" accept=".pdf,.doc,.docx" required>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Accepted formats: PDF, DOC, DOCX (Max 5MB)
                            </small>
                            @error('cv_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Submit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function copyLink() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    text: 'Job link copied to clipboard',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        }

        @if ($message = Session::get('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ $message }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>

@endsection

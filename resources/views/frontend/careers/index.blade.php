@extends('frontendLayouts.master')

@section('title', 'Careers - Join SK Sharif & Associates | Legal Jobs in Bangladesh')
@section('meta_description', 'Join SK Sharif & Associates. Explore career opportunities as a lawyer, advocate, or legal
    professional. Work with experienced attorneys in a dynamic legal environment.')
@section('meta_keywords', 'law jobs, careers, legal positions, Bangladesh, advocate jobs, lawyer opportunities')

@section('content')
    <!-- ==========Banner area start=========== -->
    <div class="banner">
        <div class="banner-content">
            <h1>Join Our Team</h1>
            <p>Explore exciting career opportunities with SK Sharif Law Firm</p>
        </div>
    </div>
    <!-- ==========Banner area end=========== -->

    <!-- ==========Jobs Listing Start=========== -->
    <div class="service">
        <div class="container">
            <div class="section-header">
                <h2>Available Positions</h2>
                <p>Discover opportunities to grow your career with us</p>
            </div>

            @if ($jobs->count() > 0)
                <div class="row g-4">
                    @foreach ($jobs as $job)
                        <div class="col-lg-8 col-md-10 mx-auto">
                            <div data-aos="zoom-out-up" data-aos-duration="1500" class="card job-card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h3 class="card-title">{{ $job->title }}</h3>
                                            <div class="job-meta mt-2">
                                                @if ($job->location)
                                                    <span class="meta-item">
                                                        <i class="fas fa-map-marker-alt"></i> {{ $job->location }}
                                                    </span>
                                                @endif
                                                @if ($job->job_type)
                                                    <span class="meta-item">
                                                        <i class="fas fa-briefcase"></i> {{ $job->job_type }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        @if ($job->deadline >= now())
                                            <span class="badge bg-danger">
                                                <i class="fas fa-clock"></i> Closes: {{ $job->deadline->format('d M') }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Closed</span>
                                        @endif
                                    </div>

                                    <div class="card-description">
                                        {{ Str::limit(strip_tags($job->description), 250) }}
                                    </div>

                                    @if ($job->salary_range)
                                        <p class="mt-3 mb-3">
                                            <strong><i class="fas fa-money-bill-wave text-success"></i> Salary:</strong>
                                            {{ $job->salary_range }}
                                        </p>
                                    @endif

                                    <div class="d-flex gap-2 mt-4">
                                        <a href="{{ route('careers.show', $job->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> View Details & Apply
                                        </a>
                                        @if ($job->pdf_file)
                                            <a href="{{ route('careers.download.circular', $job->id) }}"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-file-pdf"></i> Download Circular
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $jobs->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-briefcase"
                        style="font-size: 4rem; color: #ddd; margin-bottom: 20px; display: block;"></i>
                    <h4 class="text-muted mb-2">No Active Job Openings</h4>
                    <p class="text-muted mb-4">We don't have any open positions at the moment. Please check back soon or
                        contact us directly.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-home"></i> Back to Home
                    </a>
                </div>
            @endif
        </div>
    </div>
    <!-- ==========Jobs Listing End=========== -->

    <!-- ==========Why Join Us Section Start=========== -->
    <div class="service bg-light">
        <div class="container">
            <div class="section-header">
                <h2>Why Join SK Sharif Law Firm?</h2>
                <p>Be part of a dynamic team of legal professionals</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-6 col-md-6">
                    <div data-aos="zoom-out-up" data-aos-duration="1500" class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="card-icon mb-3">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <h5 class="card-title">Professional Growth</h5>
                            <p class="card-description">Develop your skills in a dynamic environment with experienced
                                mentors</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div data-aos="zoom-out-up" data-aos-duration="1500" class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="card-icon mb-3">
                                <i class="fas fa-coins"></i>
                            </div>
                            <h5 class="card-title">Competitive Packages</h5>
                            <p class="card-description">Attractive salary and comprehensive benefits package</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div data-aos="zoom-out-up" data-aos-duration="1500" class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="card-icon mb-3">
                                <i class="fas fa-users"></i>
                            </div>
                            <h5 class="card-title">Team Culture</h5>
                            <p class="card-description">Work with experienced legal professionals in a supportive
                                environment</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div data-aos="zoom-out-up" data-aos-duration="1500" class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <div class="card-icon mb-3">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h5 class="card-title">Career Development</h5>
                            <p class="card-description">Continuous learning opportunities and career advancement</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ==========Why Join Us Section End=========== -->

    <!-- ==========Contact Section Start=========== -->
    <div class="service">
        <div class="container">
            <div class="section-header">
                <h2>Get In Touch</h2>
                <p>Have questions about our career opportunities?</p>
            </div>

            <div class="row g-4 justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div data-aos="zoom-out-up" data-aos-duration="1500" class="card text-center border-0 shadow-sm">
                        <div class="card-body p-5">
                            <div class="card-icon mb-4">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h5 class="card-title">Email Us</h5>
                            <p class="mb-3">
                                <a href="mailto:advocatesnilroy@gmail.com"
                                    class="text-decoration-none">advocatesnilroy@gmail.com</a>
                            </p>
                            <p class="text-muted small">We'll get back to you as soon as possible</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-8">
                    <div data-aos="zoom-out-up" data-aos-duration="1500" class="card text-center border-0 shadow-sm">
                        <div class="card-body p-5">
                            <div class="card-icon mb-4">
                                <i class="fas fa-phone"></i>
                            </div>
                            <h5 class="card-title">Call Us</h5>
                            <p class="mb-3">
                                <a href="tel:+8801234567890" class="text-decoration-none">+880 1740-106009</a>
                            </p>
                            <p class="text-muted small">Sunday- Thursday, 9:00 AM - 5:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ==========Contact Section End=========== -->

@endsection

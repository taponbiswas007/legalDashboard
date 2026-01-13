@extends('frontendLayouts.master')
@section('title', 'Our Practice Areas - SK Sharif & Associates | Legal Services')
@section('meta_description', 'Explore our practice areas: Civil Law, Family Law, Criminal Law, Business Law, Education
    Law, and more. Expert legal representation from SK Sharif & Associates.')
@section('meta_keywords', 'practice areas, civil law, criminal law, family law, business law, education law, cyber law,
    Bangladesh')
@section('content')
    <!-- ==========Banner area start=========== -->
    <div class="banner">
        <div class="banner-content">
            <h1>Our Practice Areas</h1>
            <p>We specialize in a wide range of legal practice areas, offering expert advice and representation to meet your
                unique legal needs.</p>
        </div>
    </div>
    <!-- ==========Banner area end=========== -->

    <!-- Service Start -->
    <div class="service ">
        <div class="container">
            <div class="section-header">
                <h2>Our Practices Areas</h2>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div data-aos="zoom-out-up" data-aos-duration="1500" class="card">
                        <div class="card-icon">
                            <i class="fa fa-landmark"></i>
                        </div>
                        <h2 class="card-title">Civil Law</h2>
                        <div class="card-content">
                            <img src="{{ asset('frontend_assets/img/logo.png') }}" alt="">
                            <div class="position-relative z-1">

                                <p class="card-description">Resolving disputes between individuals or
                                    organizations,
                                    focusing on rights, responsibilities, and remedies like compensation.</p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card" data-aos="zoom-out-up" data-aos-duration="1500">
                        <div class="card-icon">
                            <i class="fa fa-users"></i>
                        </div>

                        <h2 class="card-title">Family Law</h2>
                        <div class="card-content">
                            <img src="{{ asset('frontend_assets/img/logo.png') }}" alt="">
                            <div class="position-relative z-1">

                                <p class="card-description">Dealing with domestic relations, including marriage,
                                    divorce, child custody, adoption, and protecting the well-being of families.</p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card" data-aos="zoom-out-up" data-aos-duration="1500">
                        <div class="card-icon">
                            <i class="fa fa-hand-holding-usd"></i>
                        </div>
                        <h2 class="card-title">Business Law</h2>
                        <div class="card-content">
                            <img src="{{ asset('frontend_assets/img/logo.png') }}" alt="">
                            <div class="position-relative z-1">

                                <p class="card-description">Governing commercial transactions, contracts,
                                    intellectual property, and corporate structures, ensuring fair trade and ethical
                                    practices.</p>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card" data-aos="zoom-out-up" data-aos-duration="1500">
                        <div class="card-icon">
                            <i class="fa fa-graduation-cap"></i>
                        </div>
                        <h2 class="card-title">Education Law</h2>
                        <div class="card-content">
                            <img src="{{ asset('frontend_assets/img/logo.png') }}" alt="">
                            <div class="position-relative z-1">

                                <p class="card-description">Shaping the educational landscape, covering student
                                    rights, school governance, funding, and ensuring equal access to quality
                                    education.</p>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card" data-aos="zoom-out-up" data-aos-duration="1500">
                        <div class="card-icon">
                            <i class="fa fa-gavel"></i>
                        </div>
                        <h2 class="card-title">Criminal Law</h2>
                        <div class="card-content">
                            <img src="{{ asset('frontend_assets/img/logo.png') }}" alt="">
                            <div class="position-relative z-1">

                                <p class="card-description">Addressing offenses against society, defining crimes,
                                    establishing punishments, and ensuring public safety through the justice system.
                                </p>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card" data-aos="zoom-out-up" data-aos-duration="1500">
                        <div class="card-icon">
                            <i class="fa fa-globe"></i>
                        </div>
                        <h2 class="card-title">Cyber Law</h2>
                        <div class="card-content">
                            <img src="{{ asset('frontend_assets/img/logo.png') }}" alt="">
                            <div class="position-relative z-1">

                                <p class="card-description">Navigating the legal complexities of the digital world,
                                    addressing online crimes, data privacy, intellectual property, and internet
                                    governance.</p>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card" data-aos="zoom-out-up" data-aos-duration="1500">
                        <div class="card-icon">
                            <i class="fa fa-heart"></i>
                        </div>
                        <h2 class="card-title">Health Law</h2>
                        <div class="card-content">
                            <img src="{{ asset('frontend_assets/img/logo.png') }}" alt="">
                            <div class="position-relative z-1">
                                <p class="card-description">Addressing legal issues in healthcare, including patient rights,
                                    medical malpractice, and regulatory compliance for healthcare providers.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card" data-aos="zoom-out-up" data-aos-duration="1500">
                        <div class="card-icon">
                            <i class="fa fa-home"></i>
                        </div>
                        <h2 class="card-title">Real Estate Law</h2>
                        <div class="card-content">
                            <img src="{{ asset('frontend_assets/img/logo.png') }}" alt="">
                            <div class="position-relative z-1">
                                <p class="card-description">Handling property transactions, disputes, zoning laws, and
                                    landlord-tenant issues to ensure smooth real estate operations.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card" data-aos="zoom-out-up" data-aos-duration="1500">
                        <div class="card-icon">
                            <i class="fa fa-balance-scale"></i>
                        </div>
                        <h2 class="card-title">Employment Law</h2>
                        <div class="card-content">
                            <img src="{{ asset('frontend_assets/img/logo.png') }}" alt="">
                            <div class="position-relative z-1">
                                <p class="card-description">Protecting employee rights, addressing workplace
                                    discrimination, wage disputes, and ensuring compliance with labor laws.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card" data-aos="zoom-out-up" data-aos-duration="1500">
                        <div class="card-icon">
                            <i class="fa fa-leaf"></i>
                        </div>
                        <h2 class="card-title">Environmental Law</h2>
                        <div class="card-content">
                            <img src="{{ asset('frontend_assets/img/logo.png') }}" alt="">
                            <div class="position-relative z-1">
                                <p class="card-description">Focusing on regulations and policies to protect the
                                    environment, including pollution control, conservation, and sustainability.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card" data-aos="zoom-out-up" data-aos-duration="1500">
                        <div class="card-icon">
                            <i class="fa fa-plane"></i>
                        </div>
                        <h2 class="card-title">Immigration Law</h2>
                        <div class="card-content">
                            <img src="{{ asset('frontend_assets/img/logo.png') }}" alt="">
                            <div class="position-relative z-1">
                                <p class="card-description">Assisting with visas, citizenship, asylum, and deportation
                                    issues to help individuals navigate complex immigration systems.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card" data-aos="zoom-out-up" data-aos-duration="1500">
                        <div class="card-icon">
                            <i class="fa fa-copyright"></i>
                        </div>
                        <h2 class="card-title">Intellectual Property Law</h2>
                        <div class="card-content">
                            <img src="{{ asset('frontend_assets/img/logo.png') }}" alt="">
                            <div class="position-relative z-1">
                                <p class="card-description">Protecting creations of the mind, including patents,
                                    trademarks, copyrights, and trade secrets, to foster innovation and creativity.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card" data-aos="zoom-out-up" data-aos-duration="1500">
                        <div class="card-icon">
                            <i class="fa fa-university"></i>
                        </div>
                        <h2 class="card-title">Tax Law</h2>
                        <div class="card-content">
                            <img src="{{ asset('frontend_assets/img/logo.png') }}" alt="">
                            <div class="position-relative z-1">
                                <p class="card-description">Advising on tax compliance, disputes, and planning to help
                                    individuals and businesses navigate complex tax regulations.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card" data-aos="zoom-out-up" data-aos-duration="1500">
                        <div class="card-icon">
                            <i class="fa fa-ship"></i>
                        </div>
                        <h2 class="card-title">Maritime Law</h2>
                        <div class="card-content">
                            <img src="{{ asset('frontend_assets/img/logo.png') }}" alt="">
                            <div class="position-relative z-1">
                                <p class="card-description">Dealing with legal matters related to navigation, shipping, and
                                    maritime commerce, including accidents and cargo disputes.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card" data-aos="zoom-out-up" data-aos-duration="1500">
                        <div class="card-icon">
                            <i class="fa fa-medkit"></i>
                        </div>
                        <h2 class="card-title">Medical Malpractice Law</h2>
                        <div class="card-content">
                            <img src="{{ asset('frontend_assets/img/logo.png') }}" alt="">
                            <div class="position-relative z-1">
                                <p class="card-description">Representing patients harmed by medical negligence and ensuring
                                    accountability in healthcare practices.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Service End -->


    <!-- Team Start -->
    <div class="team">
        <div class="container">
            <div class="section-header">
                <h2>Meet Our Expert Attorneys</h2>
            </div>
            <div class="row g-4">

                @foreach ($stafflists as $stafflist)
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="team-item" data-aos="zoom-in" data-aos-duration="1500">
                            <div class="team-img">
                                <img src="{{ asset('images/' . $stafflist->image) }}" alt="Team Image">
                            </div>
                            <div class="team-text">
                                <h2 class=" text-capitalize">{{ $stafflist->name }}</h2>
                                @if ($stafflist->qualification)
                                    <p>{{ $stafflist->qualification }}
                                @endif
                                <p>
                                <p class=" text-capitalize">{{ $stafflist->possition }}</p>

                                <div class="team-social">
                                    <a class="social-tw" href="https://wa.me/+88{{ $stafflist->whatsapp }}"><i
                                            class="fab fa-whatsapp"></i>

                                    </a>
                                    <a class="social-fb" href="tel:+88{{ $stafflist->number }}"><i
                                            class=" fa-solid fa-phone"></i>
                                    </a>
                                    <a class="social-li" href="mailto:{{ $stafflist->email }}"><i
                                            class="fa-regular fa-envelope"></i></a>
                                    {{-- <a class="social-in" href=""><i class="fab fa-facebook-messenger"></i></a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>
    <!-- Team End -->

@endsection

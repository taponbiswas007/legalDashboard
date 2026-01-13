@extends('frontendLayouts.master')
@section('title', 'SK Sharif & Associates - Expert Legal Services in Bangladesh | Home')
@section('meta_description',
    'SK Sharif & Associates is a leading law firm in Bangladesh with 20+ years of experience.
    Expert advocates providing civil, criminal, family, business and education law services.')
@section('meta_keywords', 'law firm Bangladesh, legal services Dhaka, advocate, supreme court, SK Sharif')
@include('frontendLayouts.hero')
@section('content')
    <!-- Happy New Year Popup - January Only -->
    @php
        $currentMonth = now()->month;
    @endphp

    @if ($currentMonth == 1)
        <div id="newYearModal" class="modal fade show" style="display: block; background: rgba(0, 0, 0, 0.7);" tabindex="-1"
            role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content new-year-popup">
                    <button type="button" class="btn-close position-absolute" data-dismiss="modal"
                        onclick="closeNewYearModal()" style="top: 15px; right: 15px; z-index: 10;"></button>

                    <div class="new-year-content text-center">
                        <!-- Decorative Elements -->
                        <div class="confetti-container">
                            <span class="confetti" style="left: 10%;"></span>
                            <span class="confetti" style="left: 20%;"></span>
                            <span class="confetti" style="left: 30%;"></span>
                            <span class="confetti" style="left: 40%;"></span>
                            <span class="confetti" style="left: 50%;"></span>
                            <span class="confetti" style="left: 60%;"></span>
                            <span class="confetti" style="left: 70%;"></span>
                            <span class="confetti" style="left: 80%;"></span>
                            <span class="confetti" style="left: 90%;"></span>
                        </div>

                        <!-- Main Content -->
                        <h1 class="new-year-title">🎉 Happy New Year 2026! 🎉</h1>

                        <div class="new-year-message">
                            <p class="greeting-text">Wishing you and your family a wonderful year ahead filled with success,
                                joy, and prosperity!</p>
                            <p class="sub-greeting">At SK. Sharif & Associates, we are committed to providing you with the
                                best legal services.</p>
                        </div>

                        <!-- New Year Stats -->
                        <div class="new-year-stats">
                            <div class="stat-item">
                                <h3 class="stat-number">20+</h3>
                                <p class="stat-label">Years of Experience</p>
                            </div>
                            <div class="stat-item">
                                <h3 class="stat-number">99.99%</h3>
                                <p class="stat-label">Success Rate</p>
                            </div>
                            <div class="stat-item">
                                <h3 class="stat-number">5000+</h3>
                                <p class="stat-label">Happy Clients</p>
                            </div>
                        </div>

                        <!-- CTA Button -->
                        <button type="button" class="btn btn-primary new-year-btn mt-4" onclick="closeNewYearModal()">
                            Let's Get Started
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .new-year-popup {
                border: none;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 60px 40px;
                position: relative;
                overflow: hidden;
            }

            .new-year-content {
                position: relative;
                z-index: 5;
            }

            .confetti-container {
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                overflow: hidden;
                pointer-events: none;
            }

            .confetti {
                position: absolute;
                width: 10px;
                height: 10px;
                background: linear-gradient(45deg, #FFD700, #FFA500);
                animation: confetti-fall 3s ease-in-out infinite;
                opacity: 0.8;
            }

            .confetti:nth-child(1) {
                animation-delay: 0s;
                background: #FFD700;
            }

            .confetti:nth-child(2) {
                animation-delay: 0.2s;
                background: #FF1493;
            }

            .confetti:nth-child(3) {
                animation-delay: 0.4s;
                background: #00CED1;
            }

            .confetti:nth-child(4) {
                animation-delay: 0.6s;
                background: #32CD32;
            }

            .confetti:nth-child(5) {
                animation-delay: 0.8s;
                background: #FFD700;
            }

            .confetti:nth-child(6) {
                animation-delay: 1s;
                background: #FF1493;
            }

            .confetti:nth-child(7) {
                animation-delay: 1.2s;
                background: #00CED1;
            }

            .confetti:nth-child(8) {
                animation-delay: 1.4s;
                background: #32CD32;
            }

            .confetti:nth-child(9) {
                animation-delay: 1.6s;
                background: #FFD700;
            }

            @keyframes confetti-fall {
                0% {
                    transform: translateY(-10px) rotate(0deg);
                    opacity: 1;
                }

                50% {
                    opacity: 1;
                }

                100% {
                    transform: translateY(300px) rotate(360deg);
                    opacity: 0;
                }
            }

            .new-year-title {
                font-size: 48px;
                font-weight: 700;
                margin-bottom: 20px;
                text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
                animation: pulse 2s ease-in-out infinite;
            }

            @keyframes pulse {

                0%,
                100% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.05);
                }
            }

            .new-year-message {
                margin: 25px 0;
            }

            .greeting-text {
                font-size: 18px;
                line-height: 1.6;
                margin-bottom: 10px;
                font-weight: 500;
            }

            .sub-greeting {
                font-size: 15px;
                opacity: 0.95;
                margin: 0;
            }

            .new-year-stats {
                display: flex;
                justify-content: space-around;
                gap: 20px;
                margin: 35px 0;
                flex-wrap: wrap;
            }

            .stat-item {
                background: rgba(255, 255, 255, 0.2);
                padding: 20px;
                border-radius: 15px;
                flex: 1;
                min-width: 120px;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }

            .stat-number {
                font-size: 32px;
                font-weight: 700;
                margin: 0;
                color: #FFD700;
            }

            .stat-label {
                font-size: 13px;
                margin: 8px 0 0 0;
                opacity: 0.9;
            }

            .new-year-btn {
                background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
                color: #333;
                border: none;
                padding: 12px 40px;
                font-size: 16px;
                font-weight: 600;
                border-radius: 50px;
                transition: all 0.3s ease;
                box-shadow: 0 8px 20px rgba(255, 215, 0, 0.3);
                cursor: pointer;
            }

            .new-year-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 30px rgba(255, 215, 0, 0.5);
                background: linear-gradient(135deg, #FFA500 0%, #FFD700 100%);
                color: #333;
            }

            .btn-close {
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                border: 2px solid rgba(255, 255, 255, 0.5);
                color: white;
                opacity: 1;
                font-size: 24px;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .btn-close:hover {
                background: rgba(255, 255, 255, 0.5);
                transform: rotate(90deg);
            }

            @media (max-width: 768px) {
                .new-year-popup {
                    padding: 40px 20px;
                }

                .new-year-title {
                    font-size: 36px;
                }

                .new-year-stats {
                    gap: 10px;
                }

                .stat-item {
                    min-width: 100px;
                    padding: 15px;
                }

                .stat-number {
                    font-size: 24px;
                }

                .greeting-text {
                    font-size: 16px;
                }
            }
        </style>

        <script>
            function closeNewYearModal() {
                const modal = document.getElementById('newYearModal');
                modal.style.display = 'none';
                // Store in localStorage so it doesn't show again for 24 hours
                localStorage.setItem('newYearPopupClosed', new Date().getTime());
            }

            // Auto-close after 15 seconds if user doesn't close it
            setTimeout(function() {
                const modal = document.getElementById('newYearModal');
                if (modal && modal.style.display !== 'none') {
                    closeNewYearModal();
                }
            }, 15000);
        </script>
    @endif

    <!-- Top Feature Start-->
    <div class="feature-top">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-3 col-sm-6">
                    <div class="feature-item">
                        <i class="far fa-check-circle"></i>
                        <h3>Legal</h3>
                        <p>Govt Approved</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="feature-item">
                        <i class="fa fa-user-tie"></i>
                        <h3>Attorneys</h3>
                        <p>Expert Attorneys</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="feature-item">
                        <i class="far fa-thumbs-up"></i>
                        <h3>Success</h3>
                        <p>99.99% Case Won</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="feature-item">
                        <i class="far fa-handshake"></i>
                        <h3>Support</h3>
                        <p class="subcontent">Quick Support</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top Feature End-->


    <!-- About Start -->
    <div class="overflow-hidden about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-6">
                    <div data-aos="fade-right" data-aos-duration="1500" class="about-img">
                        <img src="{{ asset('frontend_assets/img/owner-removebg.png') }}" alt="Image">
                        <div class="owner_informatiom">
                            <h1>SK. Shariful Islam (Sharif)</h1>
                            <h2>LL.B (Hon's), LL.M(I.U)</h2>
                            <h2>Advocate</h2>
                            <h2>Supreme Court of Bangladesh</h2>
                            <h3>Head of SK. Sharif & Associates</h3>
                        </div>
                    </div>

                </div>
                <div class="col-lg-7 col-md-6">
                    <div class="section-header">
                        <h2>About Us</h2>
                    </div>
                    <div data-aos="fade-left" data-aos-duration="1500" class="about-text">
                        <p>
                            SK. Sharif & Associates is a full-service law firm led by Advocate SK. Shariful Islam
                            (Sharif), an esteemed legal practitioner with an LL.B (Hon’s) and LL.M from Islamic
                            University, Bangladesh. Advocate Sharif has been representing clients with dedication
                            and integrity in the Supreme Court of Bangladesh since 2002.
                        </p>
                        <p>
                            With over two decades of experience, our firm is recognized for its excellence in
                            providing comprehensive legal services across a wide range of sectors. From civil and
                            criminal cases to family, education, cyber, business, and more, we have a dedicated team
                            of skilled lawyers who specialize in handling individual cases
                        </p>
                        <a class="mt-4 learnBtn" href="">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


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

            </div>
        </div>
    </div>
    <!-- Service End -->


    <!-- Feature Start -->
    <div class="feature">
        <div class="container">
            <div class="section-header">
                <h2>Why Choose Us</h2>
            </div>
            <div class="row">
                <div class="col-md-6">

                    <div class="row align-items-center feature-item">
                        <div class="col-5">
                            <div class="feature-icon">
                                <i class="fa fa-gavel"></i>
                            </div>
                        </div>
                        <div class="col-7">
                            <h3>Best law practices</h3>
                            <p>
                                We provide expert legal guidance with professionalism and a deep understanding of
                                the law.
                                Trust us to deliver the best solutions for your legal challenges.
                            </p>
                        </div>
                    </div>
                    <div class="row align-items-center feature-item">
                        <div class="col-5">
                            <div class="feature-icon">
                                <i class="fa fa-balance-scale"></i>
                            </div>
                        </div>
                        <div class="col-7">
                            <h3>Efficiency & Trust</h3>
                            <p>
                                Our team works efficiently with complete transparency to build a long-lasting,
                                trust-filled relationship with our clients.
                            </p>
                        </div>
                    </div>
                    <div class="row align-items-center feature-item">
                        <div class="col-5">
                            <div class="feature-icon">
                                <i class="far fa-smile"></i>
                            </div>
                        </div>
                        <div class="col-7">
                            <h3>Results you deserve</h3>
                            <p>
                                Dedicated to delivering exceptional results, we fight for the outcomes you
                                rightfully deserve.
                            </p>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="row align-items-center feature-item">
                        <div class="col-5">
                            <div class="feature-icon">
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                        <div class="col-7">
                            <h3>Experienced Team</h3>
                            <p>
                                Our team comprises highly experienced legal professionals with a proven track record
                                of success in various legal domains.
                            </p>
                        </div>
                    </div>
                    <div class="row align-items-center feature-item">
                        <div class="col-5">
                            <div class="feature-icon">
                                <i class="fa fa-handshake"></i>
                            </div>
                        </div>
                        <div class="col-7">
                            <h3>Personalized Approach</h3>
                            <p>
                                We understand that every case is unique. We offer personalized legal strategies
                                tailored to your specific needs and circumstances.
                            </p>
                        </div>
                    </div>
                    <div class="row align-items-center feature-item">
                        <div class="col-5">
                            <div class="feature-icon">
                                <i class="fa fa-phone"></i>
                            </div>
                        </div>
                        <div class="col-7">
                            <h3>24/7 Availability</h3>
                            <p>
                                We are available around the clock to address your urgent legal concerns and provide
                                immediate support when you need it most.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-5">
                                                                                                                                                                                                            <div class="feature-img">
                                                                                                                                                                                                                <img src="img/owner2.jpg" alt="Feature">
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                        </div> -->
            </div>
        </div>
    </div>
    <!-- Feature End -->


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

    <!-- X  Team Start -->
    <div class="team py-4 my-4 bg-white">
        <div class="container">
            <div class="section-header">
                <h2>Our Former Attorneys & Associates</h2>
            </div>
            <div class="row g-4">

                @foreach ($xstafflists as $stafflist)
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="team-item" data-aos="zoom-in" data-aos-duration="1500"
                            style="border: 1px solid Gray;">
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

                                <!-- <div class="team-social">
                                                <a class="social-tw" href="https://wa.me/+88{{ $stafflist->whatsapp }}"><i
                                                        class="fab fa-whatsapp"></i>

                                                </a>
                                                <a class="social-fb" href="tel:+88{{ $stafflist->number }}"><i
                                                        class=" fa-solid fa-phone"></i>
                                                </a>
                                                <a class="social-li" href="mailto:{{ $stafflist->email }}"><i
                                                        class="fa-regular fa-envelope"></i></a>
                                                {{-- <a class="social-in" href=""><i class="fab fa-facebook-messenger"></i></a> --}}
                                            </div> -->
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>
    <!-- X Team End -->


    <!-- FAQs Start -->
    <div class="faqs">
        <div class="container">
            <div class="row">
                <!-- <div class="col-md-5">
                                                                                                                                                                                                            <div class="faqs-img">
                                                                                                                                                                                                                <img src="img/faqs.jpg" alt="Image">
                                                                                                                                                                                                            </div>
                                                                                                                                                                                                        </div> -->
                <div class="col-12">
                    <div class="section-header">
                        <h2>Have A Questions?</h2>
                    </div>

                    <div id="accordion">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="faq-card">
                                    <div class="faq-card-header">
                                        <a class="faq-card-link collapsed" data-toggle="collapse" href="#collapseOne">
                                            <span>1</span>What areas of law does this firm specialize in?
                                        </a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                        <div class="faq-card-body">
                                            <p>This firm specializes in Civil Law, Business Law, Criminal Law,
                                                Education Law, Family Law, and Cyber Law.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="faq-card">
                                    <div class="faq-card-header">
                                        <a class="faq-card-link collapsed" data-toggle="collapse" href="#collapseTwo">
                                            <span>2</span> What are some common legal issues this firm can help
                                            with?
                                        </a>
                                    </div>
                                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                        <div class="faq-card-body">
                                            <p>This firm can assist with various legal matters, including contract
                                                disputes (drafting, reviewing, and enforcement), personal injury
                                                cases from accidents, business legal structure choices, arrests and
                                                criminal charges, divorce proceedings (child custody, spousal
                                                support, property division), data breaches for businesses, online
                                                harassment, and issues related to education law (discrimination and
                                                special education rights).</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="faq-card">
                                    <div class="faq-card-header">
                                        <a class="faq-card-link collapsed" data-toggle="collapse" href="#collapseThree">
                                            <span>3</span> What should someone do if they are arrested?
                                        </a>
                                    </div>
                                    <div id="collapseThree" class="collapse" data-parent="#accordion">
                                        <div class="faq-card-body">
                                            <p>If arrested, the most important action is to remain silent and
                                                immediately contact an attorney. The firm can advise on legal rights
                                                and provide representation.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="faq-card">
                                    <div class="faq-card-header">
                                        <a class="faq-card-link collapsed" data-toggle="collapse" href="#collapseFour">
                                            <span>4</span>What are some examples of family law issues this firm
                                            handles?
                                        </a>
                                    </div>
                                    <div id="collapseFour" class="collapse" data-parent="#accordion">
                                        <div class="faq-card-body">
                                            <p>In family law, this firm can help with divorce, including child
                                                custody arrangements (considering the child's best interests,
                                                parents' ability to provide care, and the child's preference if
                                                appropriate), and related issues.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="faq-card">
                                    <div class="faq-card-header">
                                        <a class="faq-card-link collapsed" data-toggle="collapse" href="#collapseFive">
                                            <span>5</span>What are some examples of business law issues this firm
                                            handles?
                                        </a>
                                    </div>
                                    <div id="collapseFive" class="collapse" data-parent="#accordion">
                                        <div class="faq-card-body">
                                            <p>This firm provides legal assistance for businesses in areas such as
                                                choosing the correct legal structure (sole proprietorship, LLC,
                                                corporation, etc.), drafting, reviewing, and negotiating contracts,
                                                and navigating the legal implications of data breaches
                                                (notifications, compliance, and prevention).</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="contact-card">
                                    <h2>Ask Me Anything</h2>
                                    <p>We value your feedback and inquiries. Please fill out the form below, and a
                                        member of our team will get back to you as soon as possible.</p>
                                    @if (session('success'))
                                        <script>
                                            Swal.fire({
                                                toast: true,
                                                icon: 'success',
                                                title: '{{ session('success') }}',
                                                position: 'top-end',
                                                showConfirmButton: false,
                                                timer: 3000,
                                                timerProgressBar: true,
                                                didOpen: (toast) => {
                                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                                }
                                            });
                                        </script>
                                    @endif
                                    <form id="dataSubmit-form" action="{{ route('contact.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="name"><i class="mx-2 fa-regular fa-user"></i>Name:</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                required>
                                            @error('name')
                                                <p class="m-2 text-danger">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="mobile"><i class="mx-2 fa-solid fa-phone"></i>Mobile
                                                Number:</label>
                                            <input type="tel" class="form-control" id="number" name="number"
                                                pattern="[0-9]{11}" placeholder="11 digits only" required>
                                            @error('number')
                                                <p class="m-2 text-danger">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email"><i class="mx-2 fa-regular fa-envelope"></i>Email
                                                Address:</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                required>
                                            @error('email')
                                                <p class="m-2 text-danger">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="question"><i class="mx-2 fa-solid fa-question"></i>Your
                                                Question:</label>
                                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                            @error('message')
                                                <p class="m-2 text-danger">
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <button id="saveButton" type="button"
                                            class="btn btn-primary btn-block">Submit</button>

                                    </form>
                                    <script>
                                        document.getElementById('saveButton').addEventListener('click', function(event) {
                                            Swal.fire({
                                                title: "Do you want to send message?",
                                                icon: "question",
                                                showDenyButton: true,
                                                showCancelButton: true,
                                                confirmButtonText: "Send",
                                                denyButtonText: `Don't Send`
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    // Proceed with form submission
                                                    Swal.fire("Saved!", "", "success").then(() => {
                                                        document.getElementById('dataSubmit-form').submit();
                                                    });
                                                }
                                            });
                                        });
                                    </script>

                                </div>
                            </div>
                        </div>







                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- FAQs End -->


    <!-- Testimonial Start -->
    <div class="testimonial">
        <div class="container">
            <div class="section-header">
                <h2>Trusted Clients</h2>
            </div>

            <div class="logo-slider-container">
                <div class="trusted-carousel owl-carousel">
                    @foreach ($trustedclients as $trustedclient)
                        <div class="logo-slide">
                            <img src="{{ asset($trustedclient->image) }}" alt="Images">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->


    <!-- Blog Start -->
    <div class="blog">
        <div class="container">
            <div class="section-header">
                <h2>Latest Blog</h2>
            </div>
            <div class="owl-carousel blog-carousel">
                @foreach ($blogs as $blog)
                    <div class="blog-item modern">
                        <div class="image_container">
                            <img src="{{ asset('images/' . $blog->image) }}" alt="Blog">
                        </div>
                        <div class="blog-content">
                            <h3>{{ $blog->title }}</h3>
                            <div class="meta">
                                <span><i class="fa fa-list-alt"></i> <a href="#">{{ $blog->category }}</a></span>
                                <span><i class="fa fa-calendar-alt"></i>{{ $blog->created_at }}</span>
                            </div>
                            <div class="overflow-hidden " style="height: 100px">
                                <p class="text-truncate max-h-4">{!! $blog->content !!}</p>
                            </div>
                            <a class="btn" href="{{ route('showblog', $blog->id) }}">Read More <i
                                    class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>
    <!-- Blog End -->


@endsection

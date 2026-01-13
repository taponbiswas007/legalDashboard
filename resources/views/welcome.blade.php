<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>SK Sharif associate</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">


    <!-- Favicon -->
    <link href="{{ asset('frontend_assets/img/logo.png') }}" rel="icon">

    <!-- Google Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@1,600;1,700;1,800&family=Roboto:wght@400;500&display=swap"
        rel="stylesheet">

    <!-- fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Bungee&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Urbanist:ital,wght@0,100..900;1,100..900&family=Playfair:ital,opsz,wght@0,5..1200,300..900;1,5..1200,300..900&display=swap"
        rel="stylesheet">


    <!-- aos -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="{{ asset('frontend_assets/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend_assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Template Stylesheet -->
    <link href="{{ asset('frontend_assets/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="preloader">
        <div class="preloader_main">
            <img src="{{ asset('frontend_assets/img/logo.png') }}" alt="Logo">
            <div class="loader"></div>
        </div>
    </div>



    <div class="wrapper overflow-hidden">
        <header class="header_area">
            <div class="container p-0">

                <nav class="px-2  navDeactive">
                    <a href="" class="logo">
                        <img src="{{ asset('frontend_assets/img/logo.png') }}" alt="SK">
                        <h1>SK. SHARIF & ASSOCIATES</h1>

                    </a>
                    <div class="d-flex align-items-center justify-content-end gap-4">
                        <ul>
                            <li><a class="active" href="index.html">Dashboard</a></li>
                            <li><a href="about.html">About</a></li>
                            <li><a href="">Practice</a></li>
                            <li><a href="">Attorney</a></li>
                            <li><a href="">Case Studies</a></li>
                            <li><a href="{{ route('careers.index') }}"><i class="fas fa-briefcase"></i> Careers</a></li>
                            <li><a href="">Contact</a></li>

                        </ul>
                        <div class="d-flex justify-content-end align-items-center column-gap-4">
                            <a href="#" class="contact d-none d-lg-block">
                                Contact
                            </a>
                            <div class="menu_bar_area menuBtn">
                                <div class="menu cross menu--1">
                                    <label>
                                        <input type="checkbox">
                                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="50" cy="50" r="30" />
                                            <path class="line--1" d="M0 40h62c13 0 6 28-4 18L35 35" />
                                            <path class="line--2" d="M0 50h70" />
                                            <path class="line--3" d="M0 60h62c13 0 6-28-4-18L35 65" />
                                        </svg>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </nav>
            </div>
        </header>


        <!-- ==========Banner area start=========== -->
        <div class="banner_area">
            <div class="inner">
                <video class=" video_items w-100 "
                    src="https://videos.pexels.com/video-files/5636977/5636977-sd_640_360_24fps.mp4" autoplay loop muted
                    playsinline></video>
                <div class="items bannerItems ">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">


                            <div class="swiper-slide">
                                <h1>
                                    Justice for All, Expertise You Can Trust
                                </h1>
                                <h2>
                                    Defending your rights with unmatched dedication and experience.
                                </h2>
                            </div>
                            <div class="swiper-slide">
                                <h1>Criminal Defense</h1>
                                <h2>Protecting your freedom with experienced criminal defense attorneys.</h2>
                            </div>
                            <div class="swiper-slide">
                                <h1>Family Law</h1>
                                <h2>Providing compassionate and professional support for family matters.</h2>
                            </div>
                            <div class="swiper-slide">
                                <h1>Personal Injury</h1>
                                <h2>Fighting for the compensation you deserve after an accident or injury.</h2>
                            </div>
                            <div class="swiper-slide">
                                <h1>Business Law</h1>
                                <h2>Expert legal counsel to help your business grow and succeed.</h2>
                            </div>
                            <div class="swiper-slide">
                                <h1>Immigration Services</h1>
                                <h2>Helping you navigate complex immigration processes with confidence.</h2>
                            </div>
                        </div>

                    </div>

                </div>


            </div>
        </div>
        <!-- ==========Banner area end=========== -->


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
        <div class="about overflow-hidden">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5 col-md-6">
                        <div data-aos="fade-right" data-aos-duration="1500" class="about-img">
                            <img src="img/owner-removebg.png" alt="Image">
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
                            <a class="learnBtn mt-4" href="">Learn More</a>
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
                                <img src="img/logo.png" alt="">
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
                                <img src="img/logo.png" alt="">
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
                                <img src="img/logo.png" alt="">
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
                                <img src="img/logo.png" alt="">
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
                                <img src="img/logo.png" alt="">
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
                                <img src="img/logo.png" alt="">
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
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="team-item" data-aos="zoom-in" data-aos-duration="1500">
                            <div class="team-img">

                                <img class="memberImg" src="img/sk_sharif.png" alt="Team Image">
                            </div>
                            <div class="team-text">
                                <h2>SK. Shariful Islam(Sharif)</h2>
                                <p>LL.B (Hon's), LL.M (I.U)</p>
                                <p>Head of SK. Sharif & Associates</p>

                                <div class="team-social">
                                    <a class="social-tw" href=""><i class="fab fa-whatsapp"></i></a>
                                    <a class="social-fb" href=""><i class=" fa-solid fa-phone"></i></a>
                                    <a class="social-li" href=""><i class="fa-regular fa-envelope"></i></a>
                                    <a class="social-in" href=""><i class="fab fa-facebook-messenger"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="team-item" data-aos="zoom-in" data-aos-duration="1500">
                            <div class="team-img">
                                <img src="img/adv_nilmadhab_roy1.png" alt="Team Image">
                            </div>
                            <div class="team-text">
                                <h2>ADV. Sree Nilmadhab Roy</h2>
                                <p>Head of Associate</p>
                                <p>Arthorin Suit And N I Act Case</p>

                                <div class="team-social">
                                    <a class="social-tw" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="social-fb" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="social-li" href=""><i class="fab fa-linkedin-in"></i></a>
                                    <a class="social-in" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="team-item" data-aos="zoom-in" data-aos-duration="1500">
                            <div class="team-img">
                                <img src="img/meraj_molla1.png" alt="Team Image">
                            </div>
                            <div class="team-text">
                                <h2>ADV. Meraj Molla</h2>
                                <p>Senior Associate</p>
                                <div class="team-social">
                                    <a class="social-tw" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="social-fb" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="social-li" href=""><i class="fab fa-linkedin-in"></i></a>
                                    <a class="social-in" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="team-item" data-aos="zoom-in" data-aos-duration="1500">
                            <div class="team-img">
                                <img src="img/md_zakariya1.png" alt="Team Image">
                            </div>
                            <div class="team-text">
                                <h2>ADV. MD. Zakaria</h2>
                                <p>Senior Associate</p>
                                <div class="team-social">
                                    <a class="social-tw" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="social-fb" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="social-li" href=""><i class="fab fa-linkedin-in"></i></a>
                                    <a class="social-in" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="team-item" data-aos="zoom-in" data-aos-duration="1500">
                            <div class="team-img">
                                <img src="img/md_zakirhossain1.png" alt="Team Image">
                            </div>
                            <div class="team-text">
                                <h2>ADV. MD. JAHIDUL ISLAM SUMON</h2>
                                <p>Senior Associate</p>
                                <div class="team-social">
                                    <a class="social-tw" href=""><i class="fab fa-twitter"></i></a>
                                    <a class="social-fb" href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="social-li" href=""><i class="fab fa-linkedin-in"></i></a>
                                    <a class="social-in" href=""><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Team End -->


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
                                            <a class="faq-card-link collapsed" data-toggle="collapse"
                                                href="#collapseOne">
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
                                            <a class="faq-card-link collapsed" data-toggle="collapse"
                                                href="#collapseTwo">
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
                                            <a class="faq-card-link collapsed" data-toggle="collapse"
                                                href="#collapseThree">
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
                                            <a class="faq-card-link collapsed" data-toggle="collapse"
                                                href="#collapseFour">
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
                                            <a class="faq-card-link collapsed" data-toggle="collapse"
                                                href="#collapseFive">
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
                                        <form id="contactForm" action="https://api.web3forms.com/submit"
                                            method="POST">
                                            <input type="hidden" name="access_key"
                                                value="69fd97b5-4251-4b30-855d-f512666037fc">
                                            <div class="form-group">
                                                <label for="name"><i
                                                        class="fa-regular fa-user mx-2"></i>Name:</label>
                                                <input type="text" class="form-control" id="name"
                                                    name="name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="mobile"><i class="fa-solid fa-phone mx-2"></i>Mobile
                                                    Number:</label>
                                                <input type="tel" class="form-control" id="mobile"
                                                    name="mobile" pattern="[0-9]{11}" placeholder="11 digits only"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email"><i class="fa-regular fa-envelope mx-2"></i>Email
                                                    Address:</label>
                                                <input type="email" class="form-control" id="email"
                                                    name="email" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="question"><i class="fa-solid fa-question mx-2"></i>Your
                                                    Question:</label>
                                                <textarea class="form-control" id="question" name="message" rows="5" required></textarea>
                                            </div>
                                            <input type="hidden" name="redirect"
                                                value="https://web3forms.com/success">
                                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                            <div id="formMessage" class="mt-3"></div>
                                        </form>

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
                    <h2>Trusted by customers</h2>
                </div>
                <!-- <div class="owl-carousel testimonials-carousel">
                    <div class="testimonial-item mx-2">
                        <i class="fa fa-quote-right"></i>
                        <div class="row align-items-center">
                            <div class="col-3">
                                <img src="img/testimonial-1.jpg" alt="">
                            </div>
                            <div class="col-9">
                                <h2>Client Name</h2>
                                <p>Profession</p>
                            </div>
                            <div class="col-12">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam accumsan lacus eget
                                    velit
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item">
                        <i class="fa fa-quote-right"></i>
                        <div class="row align-items-center">
                            <div class="col-3">
                                <img src="img/testimonial-2.jpg" alt="">
                            </div>
                            <div class="col-9">
                                <h2>Client Name</h2>
                                <p>Profession</p>
                            </div>
                            <div class="col-12">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam accumsan lacus eget
                                    velit
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item">
                        <i class="fa fa-quote-right"></i>
                        <div class="row align-items-center">
                            <div class="col-3">
                                <img src="img/testimonial-3.jpg" alt="">
                            </div>
                            <div class="col-9">
                                <h2>Client Name</h2>
                                <p>Profession</p>
                            </div>
                            <div class="col-12">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam accumsan lacus eget
                                    velit
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item">
                        <i class="fa fa-quote-right"></i>
                        <div class="row align-items-center">
                            <div class="col-3">
                                <img src="img/testimonial-4.jpg" alt="">
                            </div>
                            <div class="col-9">
                                <h2>Client Name</h2>
                                <p>Profession</p>
                            </div>
                            <div class="col-12">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam accumsan lacus eget
                                    velit
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item">
                        <i class="fa fa-quote-right"></i>
                        <div class="row align-items-center">
                            <div class="col-3">
                                <img src="img/testimonial-1.jpg" alt="">
                            </div>
                            <div class="col-9">
                                <h2>Client Name</h2>
                                <p>Profession</p>
                            </div>
                            <div class="col-12">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam accumsan lacus eget
                                    velit
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item">
                        <i class="fa fa-quote-right"></i>
                        <div class="row align-items-center">
                            <div class="col-3">
                                <img src="img/testimonial-2.jpg" alt="">
                            </div>
                            <div class="col-9">
                                <h2>Client Name</h2>
                                <p>Profession</p>
                            </div>
                            <div class="col-12">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam accumsan lacus eget
                                    velit
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item">
                        <i class="fa fa-quote-right"></i>
                        <div class="row align-items-center">
                            <div class="col-3">
                                <img src="img/testimonial-3.jpg" alt="">
                            </div>
                            <div class="col-9">
                                <h2>Client Name</h2>
                                <p>Profession</p>
                            </div>
                            <div class="col-12">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam accumsan lacus eget
                                    velit
                                </p>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="logo-slider-container">
                    <div class="logo-slider">
                        <div class="logo-slide">
                            <img src="img/logo.png" alt="Logo 1">
                        </div>
                        <div class="logo-slide">
                            <img src="img/adv_nilmadhab_roy.png" alt="Logo 2">
                        </div>
                        <div class="logo-slide">
                            <img src="img/blog-2.jpg" alt="Logo 3">
                        </div>
                        <div class="logo-slide">
                            <img src="img/md_zakariya.png" alt="Logo 4">
                        </div>
                        <div class="logo-slide">
                            <img src="img/logo.png" alt="Logo 1">
                        </div>
                        <div class="logo-slide">
                            <img src="img/adv_nilmadhab_roy.png" alt="Logo 2">
                        </div>
                        <div class="logo-slide">
                            <img src="img/blog-2.jpg" alt="Logo 3">
                        </div>
                        <div class="logo-slide">
                            <img src="img/md_zakariya.png" alt="Logo 4">
                        </div>
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
                    <div class="blog-item modern">
                        <img src="img/blog-1.jpg" alt="Blog">
                        <div class="blog-content">
                            <h3>Lorem ipsum dolor</h3>
                            <div class="meta">
                                <span><i class="fa fa-list-alt"></i> <a href="#">Education Law</a></span>
                                <span><i class="fa fa-calendar-alt"></i> 01-Jan-2045</span>
                            </div>
                            <p class="text-truncate">Lorem ipsum dolor sit amet elit. Phasellus nec pretium mi.
                                Curabitur facilisis ornare velit non vulputate. Aliquam metus tortor.</p>
                            <a class="btn" href="#">Read More <i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                    <div class="blog-item modern">
                        <img src="img/blog-2.jpg" alt="Blog">
                        <h3>Lorem ipsum dolor</h3>
                        <div class="meta">
                            <i class="fa fa-list-alt"></i>
                            <a href="">Family Law</a>
                            <i class="fa fa-calendar-alt"></i>
                            <p>01-Jan-2045</p>
                        </div>
                        <p class="text-truncate">
                            Lorem ipsum dolor sit amet elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit
                            non vulputate. Aliquam metus tortor
                        </p>
                        <a class="btn" href="">Read More <i class="fa fa-angle-right"></i></a>
                    </div>
                    <div class="blog-item modern">
                        <img src="img/blog-3.jpg" alt="Blog">
                        <h3>Lorem ipsum dolor</h3>
                        <div class="meta">
                            <i class="fa fa-list-alt"></i>
                            <a href="">Business Law</a>
                            <i class="fa fa-calendar-alt"></i>
                            <p>01-Jan-2045</p>
                        </div>
                        <p class="text-truncate">
                            Lorem ipsum dolor sit amet elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit
                            non vulputate. Aliquam metus tortor
                        </p>
                        <a class="btn" href="">Read More <i class="fa fa-angle-right"></i></a>
                    </div>
                    <div class="blog-item modern">
                        <img src="img/blog-1.jpg" alt="Blog">
                        <h3>Lorem ipsum dolor</h3>
                        <div class="meta">
                            <i class="fa fa-list-alt"></i>
                            <a href="">Education Law</a>
                            <i class="fa fa-calendar-alt"></i>
                            <p>01-Jan-2045</p>
                        </div>
                        <p class="text-truncate">
                            Lorem ipsum dolor sit amet elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit
                            non vulputate. Aliquam metus tortor
                        </p>
                        <a class="btn" href="">Read More <i class="fa fa-angle-right"></i></a>
                    </div>
                    <div class="blog-item modern">
                        <img src="img/blog-2.jpg" alt="Blog">
                        <h3>Lorem ipsum dolor</h3>
                        <div class="meta">
                            <i class="fa fa-list-alt"></i>
                            <a href="">Criminal Law</a>
                            <i class="fa fa-calendar-alt"></i>
                            <p>01-Jan-2045</p>
                        </div>
                        <p class="text-truncate">
                            Lorem ipsum dolor sit amet elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit
                            non vulputate. Aliquam metus tortor
                        </p>
                        <a class="btn" href="">Read More <i class="fa fa-angle-right"></i></a>
                    </div>
                    <div class="blog-item modern">
                        <img src="img/blog-3.jpg" alt="Blog">
                        <h3>Lorem ipsum dolor</h3>
                        <div class="meta">
                            <i class="fa fa-list-alt"></i>
                            <a href="">Cyber Law</a>
                            <i class="fa fa-calendar-alt"></i>
                            <p>01-Jan-2045</p>
                        </div>
                        <p class="text-truncate">
                            Lorem ipsum dolor sit amet elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit
                            non vulputate. Aliquam metus tortor
                        </p>
                        <a class="btn" href="">Read More <i class="fa fa-angle-right"></i></a>
                    </div>
                    <div class="blog-item modern">
                        <img src="img/blog-1.jpg" alt="Blog">
                        <h3>Lorem ipsum dolor</h3>
                        <div class="meta">
                            <i class="fa fa-list-alt"></i>
                            <a href="">Business Law</a>
                            <i class="fa fa-calendar-alt"></i>
                            <p>01-Jan-2045</p>
                        </div>
                        <p class="text-truncate">
                            Lorem ipsum dolor sit amet elit. Phasellus nec pretium mi. Curabitur facilisis ornare velit
                            non vulputate. Aliquam metus tortor
                        </p>
                        <a class="btn" href="">Read More <i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog End -->

        <!-- Newsletter Start -->
        <div class="newsletter">
            <div class="container">
                <div class="section-header">
                    <h2>Subscribe Our Newsletter</h2>
                </div>
                <div class="form-container">
                    <div class="form">
                        <input type="email" class="form-control" placeholder="Email here">
                        <button class="btn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Newsletter End -->


        <!-- Footer Start -->
        <div class="footer">
            <div class="container">
                <div class="row">

                    <div class="col-12">
                        <div class="row g-4">
                            <div class="col-md-12 col-lg-12">
                                <div class="footer-link d-flex justify-content-center align-items-center flex-column">
                                    <h2>Main office</h2>
                                    <p>Supreme Court BAR Association Main Building</p>
                                    <p>3rd Floor Room No - 412</p>

                                    <p>Dhaka - 1100</p>
                                    <a href="tel:01710884561">01710884561</a>
                                    <a
                                        href="mailto:sksharifnassociates2002@gmail.com">sksharifnassociates2002@gmail.com</a>

                                    <a
                                        href="mailto:2sksharifnassociates2002@gmail.com">2sksharifnassociates2002@gmail.com</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="footer-link">
                                    <h2>Chamber-2</h2>
                                    <p>Haque Manshion, 41/42, Court House Street</p>
                                    <p>Room no - 301, (2nd Floor)</p>
                                    <p>West Side of C.M.M Court Hajat Khana Kotwali, Dhaka-1100.</p>
                                    <a href="tel:01710884561">01710884561</a>
                                    <a
                                        href="mailto:sksharifnassociates2002@gmail.com">sksharifnassociates2002@gmail.com</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="footer-link">
                                    <h2>Chamber -3</h2>
                                    <p>23/1, Metropolitan Bar Association, (Ground Floor)</p>
                                    <p>Room no- 3</p>
                                    <p>Court House street, Dhaka-1100, Bangladesh</p>
                                    <a href="tel:01710884561">01710884561</a>
                                    <a
                                        href="mailto:sksharifnassociates2002@gmail.com">sksharifnassociates2002@gmail.com</a>
                                    <!-- <p><i class="fa fa-map-marker-alt"></i>123 Street, New York, USA</p>
                                    <p><i class="fa fa-phone-alt"></i>+012 345 67890</p>
                                    <p><i class="fa fa-envelope"></i>info@example.com</p> -->

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="footer-social">
                                    <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
                                    <a href="https://facebook.com" target="_blank"><i
                                            class="fab fa-facebook-f"></i></a>
                                    <a href="https://youtube.com" target="_blank"><i class="fab fa-youtube"></i></a>
                                    <a href="https://instagram.com" target="_blank"><i
                                            class="fab fa-instagram"></i></a>
                                    <a href="https://linkedin.com" target="_blank"><i
                                            class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container footer-menu">
                <div class="f-menu">
                    <a href="">&copy; SK. Sharif & Associates, All Right Reserved.</a>
                    <a href="https://www.bspdigitalsolutions.com">Designed by BSP Digital Solutions</a>
                    <a href="">Terms of use</a>
                    <a href="">Privacy policy</a>

                </div>
            </div>

        </div>
        <!-- Footer End -->

        <div class="button-container">
            <!-- Call Button -->
            <a href="tel:+8801710884561" class="button call-btn" title="Call Us">
                <i class="fas fa-phone-alt"></i>
            </a>

            <!-- WhatsApp Button -->
            <a href="https://wa.me/+8801710884561" class="button whatsapp-btn" title="WhatsApp">
                <i class="fab fa-whatsapp"></i>
            </a>

            <!-- Back to Top Button -->
            <a href="#" class="button back-to-top-btn" title="Back to Top">
                <i class="fas fa-arrow-up"></i>
            </a>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const navElement = document.querySelector(".navDeactive");
            const menuCheckbox = document.querySelector('.menu_bar_area input[type="checkbox"]');

            menuCheckbox.addEventListener("change", () => {
                if (menuCheckbox.checked) {
                    navElement.classList.add("navActive");
                } else {
                    navElement.classList.remove("navActive");
                }
            });
        });
    </script>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="{{ asset('frontend_assets/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('frontend_assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 30,
            effect: "slide",
            autoplay: {
                delay: 5000, // Delay in milliseconds (5000ms = 5 seconds)
                disableOnInteraction: false // Keep autoplay running even after user interaction
            },

            loop: true,

        });
    </script>
    <script src="{{ asset('frontend_assets/lib/isotope/isotope.pkgd.min.js') }}"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <!-- Template Javascript -->
    <script src="{{ asset('frontend_assets/js/main.js') }}"></script>
    <script>
        document.getElementById('contactForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formMessage = document.getElementById('formMessage');
            formMessage.innerHTML =
                '<div class="alert alert-success" role="alert">Thank you for your question! I\'ll get back to you soon.</div>';
            document.getElementById("contactForm").reset();

            setTimeout(() => {
                formMessage.innerHTML = "";
            }, 3000)

        });
    </script>


</body>


</html>

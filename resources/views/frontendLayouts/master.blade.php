<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'SK Sharif & Associates - Professional Legal Services in Bangladesh')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="@yield('meta_description', 'SK Sharif & Associates provides comprehensive legal services including civil, criminal, family, business, and education law. Expert advocates with 20+ years experience.')">
    <meta name="keywords" content="@yield('meta_keywords', 'law firm Bangladesh, legal services, advocate, civil law, criminal law, family law, business law, education law')">
    <meta name="author" content="SK Sharif & Associates">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="google-site-verification" content="TNDcH_Oyk1n_oxR3nzhrF_Tzij-xwbse9ztRnx2JnUQ">
    <meta name="revisit-after" content="7 days">
    <meta name="language" content="English">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('title', 'SK Sharif & Associates - Professional Legal Services')">
    <meta property="og:description" content="@yield('meta_description', 'Expert legal services in Bangladesh - Civil, Criminal, Family, Business Law and more')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:image" content="{{ asset('frontend_assets/img/logo.png') }}">
    <meta property="og:site_name" content="SK Sharif & Associates">
    <meta property="og:locale" content="en_US">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'SK Sharif & Associates')">
    <meta name="twitter:description" content="@yield('meta_description', 'Professional legal services')">
    <meta name="twitter:image" content="{{ asset('frontend_assets/img/logo.png') }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ request()->url() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('frontend_assets/img/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('frontend_assets/img/logo.png') }}">

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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Structured Data (Schema.org) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LegalService",
        "name": "SK Sharif & Associates",
        "description": "Professional legal services provider in Bangladesh offering civil, criminal, family, business, and education law services",
        "url": "{{ config('app.url') }}",
        "logo": "{{ asset('frontend_assets/img/logo.png') }}",
        "image": "{{ asset('frontend_assets/img/logo.png') }}",
        "telephone": "+8801710884561",
        "email": "sksharifnassociates2002@gmail.com",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "3rd Floor Room No - 412, Supreme Court BAR Association Main Building",
            "addressLocality": "Dhaka",
            "postalCode": "1100",
            "addressCountry": "BD"
        },
        "sameAs": [
            "https://www.facebook.com/sksharif",
            "https://www.linkedin.com/company/sksharif"
        ],
        "priceRange": "$$",
        "areaServed": "BD",
        "availableLanguage": "en"
    }
    </script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9NWEFQVSYE"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-9NWEFQVSYE', {
            'page_path': window.location.pathname,
            'anonymize_ip': true
        });
    </script>
</head>

<body>

    <div class="preloader">
        <div class="preloader_main">
            <img src="{{ asset('frontend_assets/img/logo.png') }}" alt="Logo">
            <div class="loader"></div>
        </div>
    </div>
    <div class="overflow-hidden wrapper">
        @include('frontendLayouts.header')
        @yield('content')
        @include('frontendLayouts.footer')
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Handle modal image display
            $('#imageModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget); // Button that triggered the modal
                const imageSrc = button.data('image'); // Extract image URL from data-image attribute
                const modal = $(this);
                modal.find('#modalImage').attr('src', imageSrc); // Set the image source
            });

            // Reset modal image on close
            $('#imageModal').on('hidden.bs.modal', function() {
                $('#modalImage').attr('src', ''); // Clear the image source
            });
        });
    </script>

</body>


</html>

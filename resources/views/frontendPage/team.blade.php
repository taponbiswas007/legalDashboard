@extends('frontendLayouts.master')
@section('title', 'Our Attorneys - SK Sharif & Associates | Expert Legal Team')
@section('meta_description', 'Meet our expert team of attorneys at SK Sharif & Associates. Skilled lawyers specializing
    in various areas of law with proven track record of success.')
@section('meta_keywords', 'attorneys, lawyers, legal team, advocates, professional lawyers, Bangladesh')
@section('content')
    <!-- ==========Banner area start=========== -->
    <div class="banner">
        <div class="banner-content">
            <h1>Our Attorneys</h1>
            <p>Our team of skilled attorneys brings a wealth of experience and a proven track record of success across a
                wide range of legal practice areas. With a deep commitment to our clients, we strive to deliver strategic,
                results-driven solutions tailored to your unique needs.</p>

        </div>
    </div>
    <!-- ==========Banner area end=========== -->



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

@extends('frontendLayouts.master')
@section('title', 'Contact Us - SK Sharif & Associates | Get Legal Help Now')
@section('meta_description',
    'Contact SK Sharif & Associates today for legal consultation. Phone: +8801710884561 |
    Email: sksharifnassociates2002@gmail.com | Located in Dhaka, Bangladesh.')
@section('meta_keywords', 'contact law firm, legal consultation, phone number, email, address, Dhaka office')
@section('content')
    <!-- ==========Banner area start=========== -->
    <div class="banner">
        <div class="banner-content">
            <h1>Contact Us</h1>
            <p>Reach out to us today to discuss your legal needs. Our experienced team is here to provide personalized
                guidance and support to help you achieve the best possible outcome.</p>

        </div>
    </div>
    <!-- ==========Banner area end=========== -->
    <!-- Contact Start -->
    <div class="contact">
        <div class="container">
            <div class="section-header">
                <h2>Contact Us</h2>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fa fa-map-marker-alt"></i>
                            <div class="contact-text">
                                <h2>Location</h2>
                                <p>3rd Floor Room No - 412</p>
                                <p>Supreme Court BAR Association Main Building</p>
                                <p>Dhaka - 1100</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fa fa-phone-alt"></i>
                            <div class="contact-text">
                                <h2>Phone</h2>
                                <p>+8801710884561</p>

                            </div>
                        </div>
                        <div class="contact-item">
                            <i class="fa fa-envelope"></i>
                            <div class="contact-text">
                                <h2>Email</h2>
                                <p>sksharifnassociates2002@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact-form">
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
                            <input type="text" name="name" class="form-control" placeholder="Your Name"
                                required="required">
                            @error('name')
                                <p class="m-2 text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                            <input type="email" name="email" class="form-control" placeholder="Your Email"
                                required="required">
                            @error('email')
                                <p class="m-2 text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                            <input type="text" name="number" class="form-control" placeholder="Mobile number"
                                required="required">
                            @error('number')
                                <p class="m-2 text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                            <textarea class="form-control" name="message" placeholder="Message" required="required"></textarea>
                            @error('message')
                                <p class="m-2 text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                            <button id="saveButton" type="button">Send Message</button>
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
    <!-- Contact End -->

@endsection

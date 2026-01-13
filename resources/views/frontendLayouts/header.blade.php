<header class="header_area">
    <div class="container p-0">

        <nav class="px-2 navDeactive">
            <a href="" class="logo">
                <img src="{{ asset('frontend_assets/img/logo.png') }}" alt="SK">
                <h1>SK. SHARIF & ASSOCIATES</h1>

            </a>
            <div class="gap-4 d-flex align-items-center justify-content-end">
                <ul>
                    <li><a class="{{ request()->is('/') ? 'active' : ' ' }}" href="{{ route('home') }}">Home</a></li>
                    <li><a class="{{ request()->is('aboutus') ? 'active' : ' ' }}" href="{{ url('aboutus') }}">About</a>
                    </li>
                    <li><a class="{{ request()->is('practice') ? 'active' : ' ' }}"
                            href="{{ route('practice') }}">Practice</a></li>
                    <li><a class="{{ request()->is('teams') ? 'active' : ' ' }}"
                            href="{{ route('teams') }}">Attorneys</a></li>
                    <li><a class="{{ request()->is('gallery') ? 'active' : ' ' }}"
                            href="{{ route('gallery') }}">Gallery</a></li>
                    <li><a class="{{ request()->is('careers') ? 'active' : ' ' }}"
                            href="{{ route('careers.index') }}">Careers</a></li>




                </ul>
                <div class="d-flex justify-content-end align-items-center column-gap-4">
                    <a href="{{ route('contactus') }}" class="contact d-none d-lg-block">
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

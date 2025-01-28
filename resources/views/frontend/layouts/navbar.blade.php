<div class="navbar-wrapper">
    <div class="container-fluid h-100">
        <nav class="navbar h-100">
            <div class="menuContainer d-flex align-items-center gap-5">
                <div class="navbar-brand">
                    <div class="mobile-nav-toggler">
                        <img src="{{ asset('frontend/assets/images/icon/hamburger.svg') }}" alt=""
                            class="w-auto h-auto">
                    </div>
                    <div class="brandlogo">
                        <img src="{{ asset('frontend/assets/images/brand/logo.svg') }}" alt="" class="w-auto h-auto">
                    </div>
                </div>
                <div class="nav-menu ps-5">
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">
                                Services
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="#">
                                Help
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">
                                About Us
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="navbar-right d-flex gap-2 align-items-center">
                <div class="language me-4">
                    EN
                </div>
                <div class="profileContainer d-flex gap-2">
                    <a href="{{ route('login') }}"
                        class="btn btn-link btn-md d-flex align-items-center justify-content-center">Log
                        in</a>
                    <a href="register.html"
                        class="btn btn-primary btn-md d-flex align-items-center justify-content-center">Sign up</a>
                    {{-- <div class="profile position-relative desktop" data-bs-toggle="tooltip" data-bs-placement="bottom"
                        data-bs-title="Profile">
                        <img src="{{ asset('frontend/assets/images/user.png') }}" alt=""
                            class="profile-btn  dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="dropdown-menu" onclick="event.stopPropagation()">
                            <ul class="d-flex flex-column gap-3">
                                <li class="nav-item">
                                    <a href="user_profile.html" class="nav-link">
                                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <circle class="my_acc" cx="4" cy="4" r="4"
                                                transform="matrix(-1 0 0 1 16.3652 3.95312)" stroke="#737373"
                                                stroke-width="1.5">
                                            </circle>
                                            <path class="my_acc"
                                                d="M5.36523 17.8878C5.36523 17.0274 5.90609 16.26 6.71633 15.9706V15.9706C10.3693 14.666 14.3612 14.666 18.0141 15.9706V15.9706C18.8244 16.26 19.3652 17.0274 19.3652 17.8878V19.2033C19.3652 20.3907 18.3135 21.3029 17.138 21.135L16.1836 20.9986C13.6509 20.6368 11.0796 20.6368 8.54686 20.9986L7.59244 21.135C6.41694 21.3029 5.36523 20.3907 5.36523 19.2033V17.8878Z"
                                                stroke="#737373" stroke-width="1.5"></path>
                                        </svg>
                                        <span class="title">Profile</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="setting.html" class="nav-link">
                                        <svg width="24" height="25" viewBox="0 0 24 25" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect class="cng-pass" x="4" y="9.95312" width="16" height="12"
                                                rx="4" stroke="#737373" stroke-width="1.5"></rect>
                                            <path class="cng-pass" d="M12 16.9531L12 14.9531" stroke="#737373"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            </path>
                                            <path class="cng-pass"
                                                d="M16 9.95313V7.95313C16 5.74399 14.2091 3.95312 12 3.95312V3.95312C9.79086 3.95312 8 5.74399 8 7.95312L8 9.95313"
                                                stroke="#737373" stroke-width="1.5"></path>
                                        </svg>
                                        <span class="title">Reset Password</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="setting.html" class="nav-link">
                                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path class="logout"
                                                d="M16.3652 16.9531V18.9531C16.3652 21.1623 14.5744 22.9531 12.3652 22.9531H7.36523C5.1561 22.9531 3.36523 21.1623 3.36523 18.9531V6.95313C3.36523 4.74399 5.1561 2.95312 7.36523 2.95312H12.3652C14.5744 2.95312 16.3652 4.74399 16.3652 6.95312V8.95312"
                                                stroke="#737373" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path class="logout"
                                                d="M19.3652 15.9531L21.6581 13.6602C22.0487 13.2697 22.0487 12.6365 21.6581 12.246L19.3652 9.95313"
                                                stroke="#737373" stroke-width="1.5" stroke-linecap="round"></path>
                                            <path class="logout" d="M21.3652 12.9531L9.36523 12.9531" stroke="#737373"
                                                stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                        <span class="title">Log Out</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="profile position-relative mobile" data-bs-toggle="tooltip" data-bs-placement="bottom"
                        data-bs-title="Profile">
                        <img src="{{ asset('frontend/assets/images/user.png') }}" alt=""
                            class="profile-btn  dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    </div> --}}
                </div>
            </div>

        </nav>
    </div>
</div>

<div class="mobile-menu">
    <div class="menu-backdrop"></div>
    <nav class="mobile-menu-nav">
        <div class="mobile-brand d-flex align-items-center justify-content-between">
            <div class="logo">
                <a href="index.html"> <img src="{{ asset('frontend/assets/images/brand/logo.svg') }}" alt=""
                        class="w-auto h-auto"></a>
            </div>
            <div class="close-btn ">
                <img src="{{ asset('frontend/assets/images/icon/close.png') }}" alt="">
            </div>
        </div>
        <div class="divider"></div>
        <div class="menu-outer">


        </div>
        <div class="language ">
            EN
        </div>
    </nav>
</div>

<header>
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="dropdown ms-auto mb-lg-0">
                    <a href="/dashboard" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-gray-600">{{ Auth()->user()->nama_panggilan }}</h6>
                                <p class="mb-0 text-sm text-gray-600">
                                    {{ Auth()->user()->role }}
                                </p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    @if (auth()->user()->foto)
                                        <img src="{{ asset('storage/foto/' . auth()->user()->foto) }}" height="40"
                                            width="40" alt="">
                                    @else
                                        <div class="default-profile-image"
                                            style="width: 40px; height: 40px; background-color: #fff; text-align: center; vertical-align: middle; line-height: 40px; color: #000; border-radius: 50%;">
                                            A</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                        style="min-width: 11rem">
                        <li>
                            <h6 class="dropdown-header">Hello, {{ Auth()->user()->nama_panggilan }}!</h6>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.index') }}"><i
                                    class="icon-mid bi bi-person me-2"></i> Profile Saya
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="icon-mid bi bi-box-arrow-left me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </li>


                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

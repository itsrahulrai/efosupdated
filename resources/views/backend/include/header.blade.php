<header class="app-header">
    <div class="app-header-inner">
        <button class="btn btn-icon d-lg-none" id="mobileSidebarToggle">
            <i class="fa fa-bars"></i>
        </button>



        <div class="app-header-end">
            <div class="px-lg-3 px-2 ps-0 d-flex align-items-center">
                <div class="dropdown">
                    <button
                        class="btn btn-icon btn-action-gray rounded-circle waves-effect waves-light position-relative"
                        id="ld-theme" type="button" data-bs-auto-close="outside" aria-expanded="false"
                        data-bs-toggle="dropdown">
                        <i class="fi fi-rr-brightness scale-1x theme-icon-active"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <button type="button" class="dropdown-item d-flex gap-2 align-items-center"
                                data-bs-theme-value="light" aria-pressed="false">
                                <i class="fi fi-rr-brightness scale-1x" data-theme="light"></i> Light
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item d-flex gap-2 align-items-center"
                                data-bs-theme-value="dark" aria-pressed="false">
                                <i class="fi fi-rr-moon scale-1x" data-theme="dark"></i> Dark
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item d-flex gap-2 align-items-center"
                                data-bs-theme-value="auto" aria-pressed="true">
                                <i class="fi fi-br-circle-half-stroke scale-1x" data-theme="auto"></i> Auto
                            </button>
                        </li>
                    </ul>
                </div>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <form action="{{ route('admin.clear.cache') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="dropdown-item d-flex align-items-center justify-content-between px-3 py-2 text-danger fw-semibold">

                            <span class="d-flex align-items-center gap-2">
                                <i class="fi fi-rr-broom fs-5"></i>
                                Clear Cache
                            </span>

                        </button>
                    </form>
                </li>
            </div>
            <div class="vr my-3"></div>

            <div class="vr my-3"></div>
            <div class="dropdown text-end ms-sm-3 ms-2 ms-lg-4">
                <a href="#" class="d-flex align-items-center py-2" data-bs-toggle="dropdown"
                    data-bs-auto-close="outside" aria-expanded="true">

                    <div class="text-end me-2 d-none d-lg-inline-block">
                        <div class="fw-bold text-dark">
                            {{ auth()->user()->name }}
                        </div>
                        <small class="text-body d-block lh-sm">
                            {{ ucfirst(auth()->user()->role) }}
                        </small>
                    </div>

                    <div class="avatar avatar-sm rounded-circle avatar-status-success">
                        <img src="{{ static_asset('assets/images/favicon.png') }}" alt="">
                    </div>
                </a>

                <ul class="dropdown-menu dropdown-menu-end w-225px mt-1">
                    <li class="d-flex align-items-center p-2">
                        <div class="avatar avatar-sm rounded-circle">
                            <img src="{{ static_asset('assets/images/favicon.png') }}" alt="">
                        </div>
                        <div class="ms-2">
                            <div class="fw-bold text-dark">
                                {{ auth()->user()->name }}
                            </div>
                            <small class="text-body d-block lh-sm">
                                {{ auth()->user()->email }}
                            </small>
                        </div>
                    </li>

                    <li>
                        <div class="dropdown-divider my-1"></div>
                    </li>

                    <li>
                        <div class="dropdown-divider my-1"></div>
                    </li>

                    <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                        @csrf
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 text-danger"
                                href="javascript:void(0);" onclick="document.getElementById('logoutForm').submit();">
                                <i class="fi fi-sr-exit scale-1x"></i> Log Out
                            </a>
                        </li>
                    </form>

                </ul>
            </div>

        </div>
    </div>
</header>

<!-- end::GXON Page Header -->

<div class="modal fade" id="searchResultsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-1 px-3">
                <form class="d-flex align-items-center position-relative w-100" action="#">
                    <button type="button" class="btn btn-sm border-0 position-absolute start-0 p-0 text-sm ">
                        <i class="fi fi-rr-search"></i>
                    </button>
                    <input type="text" class="form-control form-control-lg ps-4 border-0 shadow-none"
                        id="searchInput" placeholder="Search anything's">
                </form>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-2" style="height: 300px;" data-simplebar>
                <div id="recentlyResults">
                    <span class="text-uppercase text-2xs fw-semibold text-muted d-block mb-2">Recently Searched:</span>
                    <ul class="list-inline search-list">
                        <li>
                            <a class="search-item" href="index.html">
                                <i class="fi fi-rr-apps"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a class="search-item" href="chat.html">
                                <i class="fi fi-rr-comment"></i> Chat
                            </a>
                        </li>
                        <li>
                            <a class="search-item" href="calendar.html">
                                <i class="fi fi-rr-calendar"></i> Calendar
                            </a>
                        </li>
                        <li>
                            <a class="search-item" href="chart/apexchart.html">
                                <i class="fi fi-rr-chart-pie-alt"></i> Apexchart
                            </a>
                        </li>
                        <li>
                            <a class="search-item" href="pages/pricing.html">
                                <i class="fi fi-rr-file"></i> Pricing
                            </a>
                        </li>
                        <li>
                            <a class="search-item" href="email/inbox.html">
                                <i class="fi fi-rr-envelope"></i> Email
                            </a>
                        </li>
                    </ul>
                </div>
                <div id="searchContainer"></div>
            </div>
        </div>
    </div>
</div>

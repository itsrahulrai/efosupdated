<aside class="app-menubar" id="appMenubar">
    <div class="app-navbar-brand">
        <a class="navbar-brand-logo"
            href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('franchise.dashboard') }}">
            <img src="{{ static_asset('assets/images/logo/logo.jpg') }}" width="120" alt="EFOS Dashboard Logo">
        </a>

        <a class="navbar-brand-mini visible-dark"
            href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('franchise.dashboard') }}">
            <img src="{{ static_asset('assets/images/logo/logo.jpg') }}" width="120" alt="EFOS Dashboard Logo">
        </a>
    </div>

    <nav class="app-navbar" data-simplebar>
        <ul class="menubar">

            {{-- ========= COMMON DASHBOARD (ADMIN + FRANCHISE) ========= --}}
          @if (in_array(auth()->user()->role, ['admin', 'franchise']))
            <li class="menu-item">
                <a class="menu-link open"
                    href="
                    @if(auth()->user()->role === 'admin')
                        {{ route('admin.dashboard') }}
                    @elseif(auth()->user()->role === 'franchise')
                        {{ route('franchise.dashboard') }}
                    @endif
                    "
                    role="button">

                    <span class="menu-label">Dashboard</span>
                </a>
            </li>
        @endif

            {{-- ================= ADMIN MENU ================= --}}
            @if (auth()->user()->role === 'admin')
                <li class="menu-heading">
                    <span class="menu-label">Admin Management</span>
                </li>

                <li class="menu-item menu-arrow">
                    <a class="menu-link" href="javascript:void(0);" role="button">
                        <span class="menu-label">Opportunity</span>
                    </a>
                    <ul class="menu-inner">
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('admin.job-categories.index') }}">
                                Category
                            </a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('admin.job-sub-categories.index') }}">
                                Sub Category
                            </a>
                        </li>
                        <!--<li class="menu-item">-->
                        <!--    <a class="menu-link" href="{{ route('admin.companies.index') }}">-->
                        <!--        Company-->
                        <!--    </a>-->
                        <!--</li>-->
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('admin.jobs.index') }}">
                                Opportunity
                            </a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('admin.applied.jobs') }}">
                                Appiled Job
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item menu-arrow">
                    <a class="menu-link" href="javascript:void(0);" role="button">
                        <span class="menu-label">Career Updates</span>
                    </a>
                    <ul class="menu-inner">
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('admin.categories.index') }}">
                                Categories
                            </a>
                        </li>
                        <!-- <li class="menu-item">
                        <a class="menu-link" href="{{ route('admin.sub-categories.index') }}">
                            Sub Categories
                        </a>
                    </li> -->
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('admin.blogs.index') }}">
                                Blogs
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-item menu-arrow">
                    <a class="menu-link" href="javascript:void(0);" role="button">
                        <span class="menu-label">News & Events</span>
                    </a>
                    <ul class="menu-inner">
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('admin.news-events.index') }}">
                                All News & Events
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="menu-item menu-arrow">
                    <a class="menu-link" href="javascript:void(0);" role="button">
                        <span class="menu-label">Our Services </span>
                    </a>
                    <ul class="menu-inner">
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('admin.courses.index') }}">
                                Services
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-heading">
                    <span class="menu-label">Student Management</span>
                </li>
                <li class="menu-item menu-arrow">
                    <a class="menu-link" href="javascript:void(0);" role="button">
                        <span class="menu-label">Students</span>
                    </a>
                    <ul class="menu-inner">
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('admin.all.students') }}">
                                All Students
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="menu-heading">
                    <span class="menu-label">Franchise Management</span>
                </li>
                <li class="menu-item menu-arrow">
                    <a class="menu-link" href="javascript:void(0);" role="button">
                        <span class="menu-label">Franchises</span>
                    </a>
                    <ul class="menu-inner">
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('admin.become-partner.index') }}">
                                All Franchises
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="menu-heading">
                    <span class="menu-label">LMS Management</span>
                </li>
                <li class="menu-item menu-arrow">
                    <a class="menu-link" href="javascript:void(0);" role="button">
                        <span class="menu-label">Courses</span>
                    </a>
                    <ul class="menu-inner">
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('admin.subject.index') }}">
                                Category
                            </a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('admin.learning-course.index') }}">
                                Courses
                            </a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('admin.bundle-course.index') }}">
                                Bundle Courses
                            </a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('admin.assigned-course.index') }}">
                                Assigned Courses
                            </a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('admin.course.orders') }}">
                                Courses Orders
                            </a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('admin.course-chapter.index') }}">
                                Chapter
                            </a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('admin.lesson.index') }}">
                                Lesson
                            </a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('admin.quiz.index') }}">
                                Quiz
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="menu-heading">
                    <span class="menu-label">Mentor Platform</span>
                </li>

                <li class="menu-item menu-arrow">
                    <a class="menu-link" href="javascript:void(0);" role="button">
                        <span class="menu-label">Mentors</span>
                    </a>

                    <ul class="menu-inner">
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('admin.mentor-categories.index') }}">
                                Mentors
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="menu-heading">
                    <span class="menu-label">System Settings</span>
                </li>

                @php
                    // Settings should be active for all Pages routes
                    $settingsActive = request()->routeIs('admin.pages.*');
                @endphp

                <li class="menu-item menu-arrow {{ $settingsActive ? 'open active' : '' }}">
                    <a class="menu-link" href="javascript:void(0);" role="button">
                        <span class="menu-label">Settings</span>
                    </a>

                    <ul class="menu-inner">

                        <!-- Pages -->
                        <li class="menu-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                            <a class="menu-link" href="{{ route('admin.pages.index') }}">
                                Pages
                            </a>
                        </li>
                        <!-- Pages -->
                        <li class="menu-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                            <a class="menu-link" href="{{ route('admin.youtube.index') }}">
                                Youtube
                            </a>
                        </li>

                    </ul>
                </li>
            @endif

            {{-- ================= FRANCHISE MENU ================= --}}
            @if (auth()->user()->role === 'franchise')
                <li class="menu-heading">
                    <span class="menu-label">Franchise Panel</span>
                </li>

                <li class="menu-item menu-arrow">
                    <a class="menu-link" href="javascript:void(0);" role="button">
                        Applications
                    </a>
                    <ul class="menu-inner">
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('franchise.index') }}">
                                Franchise Profile
                            </a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="{{ route('students.franchise') }}">
                                Students
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

        </ul>

    </nav>

</aside>

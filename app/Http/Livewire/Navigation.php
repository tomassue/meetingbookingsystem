<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Navigation extends Component
{
    public function render()
    {
        return <<<'blade'
            <div>
                <!-- ======= Header ======= -->
                <header id="header" class="header fixed-top d-flex align-items-center mb-5" style="height: 100px !important; ">
            
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                        <a href="" class="logo d-flex align-items-center justify-content-center">
                            <img src="{{ asset('images/cdo-seal.png') }}" class="img-fluid" alt="">
                            <img src="{{ asset('images/rise.png') }}" class="img-fluid" alt="">
                        </a>
                        </div>
                        <i class="bi bi-list toggle-sidebar-btn" style="color: #2B4F43;"></i>
                
                        <div>
                        <h1 class="dtitle1 px-3 mt-1">Meeting Booking System</h1>
                        </div>
                    </div>
                    <!-- End Logo -->
            
                    <!-- a code here is deleted. copy of that code is in TRELLO -->
                        
                    <nav class="header-nav ms-auto">

                    <ul class="d-flex align-items-center">
                        
                        <li class="nav-item dropdown">
                
                        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-bell"></i>
                            <span class="badge bg-primary badge-number">4</span>
                        </a>
                        <!-- End Notification Icon -->
                
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                            <li class="dropdown-header">
                            You have 4 new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                            </li>
                            <li>
                            <hr class="dropdown-divider">
                            </li>
                
                            <li class="notification-item">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <div>
                                <h4>Lorem Ipsum</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>30 min. ago</p>
                            </div>
                            </li>
                
                            <li>
                            <hr class="dropdown-divider">
                            </li>
                
                            <li class="notification-item">
                            <i class="bi bi-x-circle text-danger"></i>
                            <div>
                                <h4>Atque rerum nesciunt</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>1 hr. ago</p>
                            </div>
                            </li>
                
                            <li>
                            <hr class="dropdown-divider">
                            </li>
                
                            <li class="notification-item">
                            <i class="bi bi-check-circle text-success"></i>
                            <div>
                                <h4>Sit rerum fuga</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>2 hrs. ago</p>
                            </div>
                            </li>
                
                            <li>
                            <hr class="dropdown-divider">
                            </li>
                
                            <li class="notification-item">
                            <i class="bi bi-info-circle text-primary"></i>
                            <div>
                                <h4>Dicta reprehenderit</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>4 hrs. ago</p>
                            </div>
                            </li>
                
                            <li>
                            <hr class="dropdown-divider">
                            </li>
                            <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                            </li>
                
                        </ul>
                        <!-- End Notification Dropdown Items -->
                
                        </li>
                        <!-- End Notification Nav -->
                
                        <li class="nav-item dropdown pe-3">
                
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle"> -->
                            <span class="d-none d-md-block dropdown-toggle ps-2"> {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
                        </a>
                        <!-- End Profile Iamge Icon -->
                
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile" style="">
                            <li class="dropdown-header">
                            <h6> {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</h6>
                            <span> {{ Auth::user()->ref_departments->department_name }} </span>
                            </li>
                            <li>
                            <hr class="dropdown-divider">
                            </li>
                
                            
                
                            <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('account-settings') }}">
                                <i class="bi bi-gear"></i>
                                <span>Account Settings</span>
                            </a>
                            </li>

                            <li>
                            <hr class="dropdown-divider">
                            </li>

                            <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                            </form>
                            </li>
                
                        </ul>
                        <!-- End Profile Dropdown Items -->
                        </li>
                        <!-- End Profile Nav -->
                
                    </ul>
                    </nav>
                    <!-- End Icons Navigation -->
            
                </header><!-- End Header -->
            
                <!-- ======= Sidebar ======= -->
                <aside id="sidebar" class="sidebar mt-5" style="padding-right: 0px;">
                    <ul class="sidebar-nav" id="sidebar-nav">
                
                        <li class="nav-item ">
                        <a class="nav-link collapsed {{ 'schedule' == request()->path() ? 'active' : '' }}" href="{{route('schedule')}}">
                            <span class="bi bi-grid"> </span>
                            <span>{{ (Auth::user()->account_type == 0 ? 'All Schedules' : 'My Schedule')}} </span>
                        </a>
                        </li>
                
                        <li class="nav-item">
                        <a class="nav-link collapsed {{ 'book' == request()->path() ? 'active' : '' }}" href="{{route('book')}}">
                            <span class="bi bi-layout-text-window-reverse"> </span>
                            <span>Book a Meeting</span>
                        </a>
                        </li>
                
                        <li class="nav-item">
                        <a class="nav-link collapsed {{ 'viewsched' == request()->path() ? 'active' : '' }}" href="{{route('viewsched')}}">
                            <span class="bi bi-calendar2-week"> </span>
                
                            <span>View Schedule</span>
                        </a>
                        </li>

                        @if(Auth::user()->account_type == 0)
                
                        <li class="nav-item">
                        <a class="nav-link collapsed {{ 'request' == request()->path() ? 'active' : '' }}" href="{{route('request')}}">
                            <span class="ri-git-pull-request-line"> </span>
                            <span>Request</span>
                        </a>
                        </li>

                        <li class="nav-item">
                        <a class="nav-link collapsed {{ 'user-management' == request()->path() ? 'active' : '' }}" href="{{route('user-management')}}">
                            <span class="ri-folder-user-line"> </span>
                            <span>User Management</span>
                        </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#" aria-expanded="false" style="padding: 10px 15px !important; border-radius: unset !important;">
                            <span class="ri-links-fill"> </span>
                            <span>References</span>
                            </a>
                            <ul id="icons-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav" style="">
                            <li>
                                <a href="{{ route('ref-departments') }}">
                                <i class="bi bi-circle"></i>
                                <span class="ref">Departments</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('ref-signatories') }}">
                                <i class="bi bi-circle"></i>
                                <span class="ref">Signatories</span>
                                </a>
                            </li>
                            </ul>
                        </li>

                        @endif
                    </ul>
                </aside>

                <!-- Vendor JS Files -->
                <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                <script src="{{asset('theme/vendor/apexcharts/apexcharts.min.js')}}"></script>
                <script src="{{asset('theme/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
                <script src="{{asset('theme/vendor/chart.js/chart.umd.js')}}"></script>
                <script src="{{asset('theme/vendor/echarts/echarts.min.js')}}"></script>
                <script src="{{asset('theme/vendor/quill/quill.min.js')}}"></script>
                <script src="{{asset('theme/vendor/simple-datatables/simple-datatables.js')}}"></script>
                <script src="{{asset('theme/vendor/tinymce/tinymce.min.js')}}"></script>
                <script src="{{asset('theme/vendor/php-email-form/validate.js')}}"></script>

                <script src="{{asset('theme/js/main.js')}}"></script>
                <script src="{{asset('jquery-ui-1.13.2/external/jquery/jquery.js')}}"></script>
                <script src="{{asset('jquery-ui-1.13.2/jquery-ui.min.js')}}"></script>
                <script src="{{asset('jquery-ui-1.13.2/jquery-ui.js')}}"></script>

                <!-- select2 -->
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                <script src="{{asset('select2/js/select2.full.min.js')}}"></script>
                
            </div>
        blade;
    }
}

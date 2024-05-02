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
            
                    <ul class="navbar-nav ms-auto d-flex justify-content-right" style="margin-left: 40% !important">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->account_type }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                            </a>
                
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                            </form>
                        </div>
                        </li>
                        @endguest
                    </ul>
                        
                    <nav class="header-nav ms-auto">
                
                    </nav>
                    <!-- End Icons Navigation -->
            
                </header><!-- End Header -->
            
                <!-- ======= Sidebar ======= -->
                <aside id="sidebar" class="sidebar mt-5" style="padding-right: 0px;">
                    <ul class="sidebar-nav" id="sidebar-nav">
                
                        <li class="nav-item ">
                        <a class="nav-link collapsed {{ 'schedule' == request()->path() ? 'active' : '' }}" href="{{route('schedule')}}">
                            <span class="bi bi-grid"> </span>
                            <span>My Schedule</span>
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
                        </li>

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

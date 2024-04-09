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
                            {{ Auth::user()->name }}
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
                        <a class="nav-link collapsed {{ 'schedule' == request()->path() ? 'active' : '' }}" href="{{route('schedule')}} " href="{{route('schedule')}}">
                            <span class="bi bi-grid"> </span>
                            <span>My Schedule</span>
                        </a>
                        </li>
                
                        <li class="nav-item">
                        <a class="nav-link collapsed {{ 'book' == request()->path() ? 'active' : '' }}" href="{{route('book')}} " href="{{route('book')}}">
                            <span class="bi bi-layout-text-window-reverse"> </span>
                            <span>Book Meeting</span>
                        </a>
                        </li>
                
                        <li class="nav-item">
                        <a class="nav-link collapsed {{ 'viewsched' == request()->path() ? 'active' : '' }}" href="{{route('viewsched')}} " href="{{route('viewsched')}}">
                            <span class="bi bi-calendar2-week"> </span>
                
                            <span>View Schedule</span>
                        </a>
                        </li>
                
                        <li class="nav-item">
                        <a class="nav-link collapsed {{ 'request' == request()->path() ? 'active' : '' }}" href="{{route('request')}} " href="{{route('request')}}">
                            <span class="ri-git-pull-request-line"> </span>
                            <span>Request</span>
                        </a>
                        </li>

                    </ul>
                </aside>
            </div>
        blade;
    }
}

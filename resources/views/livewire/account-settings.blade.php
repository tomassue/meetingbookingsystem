<div>
    @if(session('success'))
    <div class="mt-5">
        <div class="mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    <div class="row">

        <div class="col-xl-4">

            <div class="card @if(!session('success')) mt-5 @endif text-start">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                    <h2>{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</h2>
                    <h3>{{ Auth::user()->ref_departments->department_name ?? 'No Department Assigned' }}</h3>

                    <div class="social-links mt-2">
                        <!-- <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a> -->
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xl-8">

            <div class="card @if(!session('success')) mt-5 @endif text-start">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">

                        <!-- <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-overview" aria-selected="false" role="tab" tabindex="-1">Overview</button>
                </li> -->

                        <!-- <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit" aria-selected="false" role="tab" tabindex="-1">Edit Profile</button>
                </li> -->

                        <!-- <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings" aria-selected="false" role="tab" tabindex="-1">Settings</button>
                </li> -->

                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-change-password" aria-selected="true" role="tab">Change Password</button>
                        </li>

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade profile-overview" id="profile-overview" role="tabpanel">
                            <!-- CONTENT HERE -->
                        </div>

                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit" role="tabpanel">

                            <!-- Profile Edit Form -->
                            <!-- End Profile Edit Form -->

                        </div>

                        <div class="tab-pane fade pt-3" id="profile-settings" role="tabpanel">

                            <!-- Settings Form -->
                            <!-- End settings Form -->

                        </div>

                        <div class="tab-pane fade pt-3 active show" id="profile-change-password" role="tabpanel">

                            <div class="text-center">
                                @if($check_default_password)
                                <span class="badge bg-warning text-dark mb-3">
                                    <i class="bi bi-exclamation-triangle me-1"></i> You need to update your password. Thank you.
                                </span>
                                @endif
                            </div>

                            <!-- Change Password Form -->
                            <form wire:submit.prevent="updatePassword" data-bitwarden-watching="1" novalidate>

                                <div class="row mb-3">
                                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" wire:model="current_password">
                                        @error('current_password') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">
                                        New Password
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="The password must have at least 8 characters, contain both letters, numbers, and special characters.">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                                        </svg>
                                    </label>
                                    <div class="col-md-8 col-lg-9">
                                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" wire:model="new_password">
                                        @error('new_password') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="confirmPassword" class="col-md-4 col-lg-3 col-form-label">Confirm New Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" wire:model="confirm_password">
                                        @error('confirm_password') <div class="invalid-feedback"> {{ $message }} </div> @enderror
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </form><!-- End Change Password Form -->

                        </div>

                    </div><!-- End Bordered Tabs -->

                </div>
            </div>

        </div>
    </div>

</div>
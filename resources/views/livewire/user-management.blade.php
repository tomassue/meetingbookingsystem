<div>
    <div class="card mt-5 text-start">
        <div class="card-body">
            <h5 class="card-title">User Management</h5>
            <div class="text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10ZM3.41 22c0-3.87 3.85-7 8.59-7 .96 0 1.89.13 2.76.37" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M22 18c0 .32-.04.63-.12.93-.09.4-.25.79-.46 1.13A3.97 3.97 0 0 1 18 22a3.92 3.92 0 0 1-2.66-1.03c-.3-.26-.56-.57-.76-.91A3.92 3.92 0 0 1 14 18a3.995 3.995 0 0 1 4-4c1.18 0 2.25.51 2.97 1.33.64.71 1.03 1.65 1.03 2.67ZM19.49 17.98h-2.98M18 16.52v2.99" stroke="#ffffff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Department</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Brandon Jacob</td>
                            <td>Designer</td>
                            <td>
                                <a href="#" role="button" class="btn btn-sm btn-danger">RESET PASSWORD</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- addUserModal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-start">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addUserModalLabel">Add User</h1>
                    <button type="button" class="btn-close btn-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" data-bitwarden-watching="1">
                        <div class="col-md-6">
                            <label for="inputName5" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="inputName5">
                        </div>
                        <div class="col-md-6">
                            <label for="inputName5" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="inputName5">
                        </div>
                        <div class="col-md-6">
                            <label for="inputName5" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="inputName5">
                        </div>
                        <div class="col-md-6">
                            <label for="inputName5" class="form-label">Extension Name</label>
                            <input type="text" class="form-control" id="inputName5">
                        </div>
                        <div class="col-12">
                            <label for="inputEmail5" class="form-label">Username (Email)</label>
                            <input type="email" class="form-control" id="inputEmail5">
                        </div>
                        <div class="col-12">
                            <label for="inputAddress5" class="form-label">Department</label>
                            <select id="inputState" class="form-select">
                                <option selected="">Choose...</option>
                                <option>...</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="inputAddress2" class="form-label">User Role</label>
                            <select id="inputState" class="form-select">
                                <option selected="" disabled>Choose...</option>
                                <option value="1">Admin</option>
                                <option value="2">Editor</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" style="background-color: #0A927C; border-color: #0A927C;">Save changes</button>
                </div>
            </div>
        </div>
    </div>

</div>
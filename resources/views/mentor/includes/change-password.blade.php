<div class="slot-card">

    <h6 class="mb-3">Change Password</h6>

    <form action="{{ route('mentor.password.update') }}" method="POST">

        @csrf

        <div class="row g-3">

            <div class="col-md-6">

                <label class="form-label small">
                    Current Password
                </label>

                <input type="password" name="current_password" class="form-control form-control-sm" required>

            </div>


            <div class="col-md-6">

                <label class="form-label small">
                    New Password
                </label>

                <input type="password" name="new_password" class="form-control form-control-sm" required>

            </div>


            <div class="col-md-6">

                <label class="form-label small">
                    Confirm Password
                </label>

                <input type="password" name="new_password_confirmation" class="form-control form-control-sm" required>

            </div>

        </div>


        <div class="text-end mt-3">

            <button type="submit" class="btn btn-success btn-sm">

                Update Password

            </button>

        </div>

    </form>

</div>

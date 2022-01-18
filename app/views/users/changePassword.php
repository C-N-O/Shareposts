<?php require APPROOT . '/views/includes/header.php'; ?>
    <a href="<?php echo URLROOT;  ?>/users/profile" class="btn btn-dark"><i class="fa fa-backward"></i> Back To Profile</a>

    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h2>Change Your Password</h2>
                <form action="<?php echo URLROOT; ?>/users/changePassword" method="post">
                    <div class="form-group">
                        <label for="old-password">Old Password: <sup>*</sup></label>
                        <input type="password" name="old-password" class="form-control form-control-lg <?php
                        echo empty($data['old_password_err']) ? '' : 'is-invalid' ?>" value="<?php echo $data['old_password']; ?>">
                        <span class="invalid-feedback"><?php echo $data['old_password_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="new-password">New Password: <sup>*</sup></label>
                        <input type="password" name="new-password" class="form-control form-control-lg <?php
                        echo empty($data['new_password_err']) ? '' : 'is-invalid' ?>" value="<?php echo $data['new_password']; ?>">
                        <span class="invalid-feedback"><?php echo $data['new_password_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="confirm-new-password">Confirm New Password: <sup>*</sup></label>
                        <input type="password" name="confirm-new-password" class="form-control form-control-lg <?php
                        echo empty($data['confirm_new_password_err']) ? '' : 'is-invalid' ?>" value="<?php echo $data['confirm_new_password']; ?>">
                        <span class="invalid-feedback"><?php echo $data['confirm_new_password_err']; ?></span>
                    </div>

                    <div class="row mt-2">
                        <div class="col">
                            <input type="submit" value="Submit" class="btn btn-success form-control">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
<?php require APPROOT . '/views/includes/footer.php'; ?>
<?php require APPROOT . '/views/includes/header.php'; ?>

    <a href="<?php echo URLROOT;  ?>/users/profile" class="btn btn-dark"><i class="fa fa-backward"></i> Back To Profile</a>

    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h2>Edit Your Account</h2>
                <p>Update your details.</p>
                <form action="<?php echo URLROOT; ?>/users/edit/" method="post">
                    <div class="form-group">
                        <label for="name">Name: <sup>*</sup></label>
                        <input type="text" name="name" class="form-control form-control-lg <?php
                        echo empty($data['name_err']) ? '' : 'is-invalid' ?>" value="<?php echo $data['name']; ?>">
                        <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email: <sup>*</sup></label>
                        <input type="email" name="email" class="form-control form-control-lg <?php
                        echo empty($data['email_err']) ? '' : 'is-invalid' ?>" value="<?php echo $data['email']; ?>">
                        <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                    </div>

                    <div class="row mt-2">
                        <div class="col">
                            <input type="submit" value="Update" class="btn btn-success form-control">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
<?php require APPROOT . '/views/includes/footer.php'; ?>
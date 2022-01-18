<?php require APPROOT . '/views/includes/header.php'; ?>

    <div class="row">

        <div class="col-md-6 mx-auto">
            <?php flash('user_message'); ?>

            <div class="card card-body bg-light mt-5">
                <h2>Welcome <?php echo $data['name'];  ?>!</h2>
                <p>You can make any changes to your profile here.</p>

                <div>
                    <h5><strong>Name: </strong><?php echo $data['name'];  ?></h5>
                </div>

                <div>
                    <h5><strong>Email: </strong><?php echo $data['email'];  ?></h5>
                </div>

                <a href="<?php echo URLROOT;  ?>/users/edit/<?php echo $data['id'] ?>" class="btn btn-dark">EDIT</a>
                <br>
                <br>
                <a href="<?php echo URLROOT;  ?>/users/changePassWord/<?php echo $data['id'] ?>" class="btn btn-dark">CHANGE PASSWORD</a>
                <br>
                <br>
                <a href="<?php echo URLROOT;  ?>/users/confirmDelete/" class="btn btn-danger">DELETE YOUR ACCOUNT</a>

            </div>
        </div>
    </div>

<?php require APPROOT . '/views/includes/footer.php'; ?>
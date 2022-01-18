<?php require APPROOT . '/views/includes/header.php'; ?>
    <a href="<?php echo URLROOT;  ?>/admins/index" class="btn btn-dark"><i class="fa fa-backward"></i> Back To Dashboard</a>

    <div class="row">

        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">

                <div>
                    <h5><strong>Name: </strong><?php echo $data['user']->name;  ?></h5>
                </div>
                <div>
                    <h5><strong>Email: </strong><?php echo $data['user']->email;  ?></h5>
                </div>

                <div>
                    <h5><strong>Active Since: </strong><?php echo $data['user']->created_at;  ?></h5>
                </div>

                <a href="#" class="btn btn-dark">EDIT USER INFO</a>
                <br>
                <br>
                <a href="#" class="btn btn-danger">DELETE THIS USER</a>
                <br>
                <a href="<?php echo URLROOT?>/admins/showUserPosts/<?php echo $data['user']->id;  ?>" class="btn btn-info">ALL POSTS BY THIS USER</a>
                <br>
            </div>
        </div>
    </div>

<?php require APPROOT . '/views/includes/footer.php'; ?>
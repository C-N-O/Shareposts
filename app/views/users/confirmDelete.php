<?php require APPROOT . '/views/includes/header.php'; ?>

<div class="jumbotron jumbotron-flud text-center">
    <div class="container">
        <h1 class="display-3">Wait! ⛔️</h1>
        <p class="lead">Are you sure you want to delete your account?</p>
        <p class="lead">You cannot undo this action.</p>
        <p class="lead">All of your posts would also be deleted.</p>
    </div>
    <br>
    <a href="<?php echo URLROOT;  ?>/users/profile" class="btn btn-dark"><i class="fa fa-backward"></i> BACK TO PROFILE</a>
    <a href="<?php echo URLROOT;  ?>/users/delete/<?php echo $data['id'] ?>" class="btn btn-danger">DELETE MY ACCOUNT</a>
</div>

<?php require APPROOT . '/views/includes/footer.php'; ?>

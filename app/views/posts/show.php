<?php require APPROOT . '/views/includes/header.php'; ?>
<a href="<?php echo URLROOT;  ?>/posts/index" class="btn btn-dark"><i class="fa fa-backward"></i>
    <?php if($_SESSION['user_id'])  : ?>
        Back To Posts
    <?php elseif($_SESSION['admin_id'])  : ?>
        Back To Dashboard
    <?php endif; ?>
</a>
<br>
<br>
<h1><?php echo $data['post']->title;  ?></h1>

<div class="bg-secondary text-white p-2 mb-3">
    <p>Written by <?php echo $data['user']->name; ?> on <?php echo $data['post']->created_at; ?></p>
</div>
<p><?php echo $data['post']->body; ?></p>
<!--If the author of the post or the admin is logged in, show the edit and delete buttons-->
<?php if($data['post']->user_id == $_SESSION['user_id'] || $_SESSION['admin_id'] ) : ?>
<hr>
    <a href="<?php echo URLROOT;  ?>/posts/edit/<?php echo $data['post']->id ?>" class="btn btn-dark">EDIT</a>

    <form action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data['post']->id ?>" class="float-end" method="post">
        <input type="submit" value="Delete" class="btn btn-danger">
    </form>
<?php endif;?>





<?php require APPROOT . '/views/includes/footer.php'; ?>
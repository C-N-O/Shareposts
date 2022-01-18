
<?php require APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <h1 class="text-center bg-light"><i class="fa fa-dashboard"></i> Admin Dashboard</h1>
    <div class="row">
                <div class="col">
                    <h3 class="text-center">USERS</h3>
                    <?php foreach($data['users'] as $user) : ?>
                    <div class="bg-light p-2">
                        <p><?php echo $user->name;  ?>

                            <span class="float-end">
                        <?php echo $user->email;  ?>
                            <a href="<?php echo URLROOT; ?>/admins/showUser/<?php echo $user->id; ?>" class="btn btn-info btn-sm ms-2">View</a>
                        <a href="#" class="btn btn-secondary btn-sm ms-2">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm ms-2">Delete</a>
                        </span>
                        </p>
                    </div>

                    <?php endforeach; ?>
                </div>

        <div class="col">
            <h3 class="text-center">POSTS</h3>
            <?php foreach($data['posts'] as $post) : ?>
            <div class="bg-light p-2">
                <p><strong><?php echo $post->title;  ?></strong>

                    <span class="float-end">
                        Written by <?php echo $post->name;  ?>
                            <a href="<?php echo URLROOT;  ?>/posts/show/<?php echo $post->postId;  ?>" class="btn btn-info btn-sm ms-2">View</a>
                        <a href="#" class="btn btn-secondary btn-sm ms-2">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm ms-2">Delete</a>
                        </span>
                </p>
            </div>
            <?php endforeach; ?>
        </div>

</div>


<?php require APPROOT . '/views/includes/footer.php'; ?>


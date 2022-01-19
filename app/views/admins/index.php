
<?php require APPROOT . '/views/includes/header.php'; ?>

<div class="container">
    <h1 class="text-center bg-light"><i class="fa fa-tachometer-alt"></i> Admin Dashboard</h1>
    <div class="row">
                <div class="col">
                    <h3 class="text-center">USERS</h3>
                    <?php foreach($data['users'] as $user) : ?>
                    <div class="bg-light p-2">
                        <p><?php echo $user->name;  ?>

                            <span class="float-end">
                        <?php echo $user->email;  ?>
                            <a href="<?php echo URLROOT; ?>/admins/showUser/<?php echo $user->id; ?>" class="ms-2"><i class="fa fa-eye"></i></a>
                        <a href="#" class="ms-2"><i class="fa fa-edit"></i></a>
                        <a href="#" class="ms-2"><i class="fa fa-trash-alt"></i></a>
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
                            <a href="<?php echo URLROOT;  ?>/posts/show/<?php echo $post->postId;  ?>"><i class="fa fa-eye"></i></a>
                        <a href="#" class="ms-2"><i class="fa fa-edit"></i></a>
                        <a href="#" class="ms-2"><i class="fa fa-trash-alt"></i></a>
                        </span>
                </p>
            </div>
            <?php endforeach; ?>
        </div>

</div>


<?php require APPROOT . '/views/includes/footer.php'; ?>


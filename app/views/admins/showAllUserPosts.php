<?php require APPROOT . '/views/includes/header.php'; ?>
    <a href="<?php echo URLROOT;  ?>/admins/showUser/<?php echo $data['user']->id; ?>" class="btn btn-dark"><i class="fa fa-backward"></i> Back To User</a>

    <div class="row mb-3">
        <div class="col-md-6">
            <h1><?php echo $data['user']->name; ?>'s Posts</h1>
        </div>
    </div>

<?php foreach($data['posts'] as $post) : ?>
    <div class="card card-body mb-3">
        <h4 class="card-title"><?php echo $post->title;  ?></h4>
        <div class="bg-light p-2 mb-3">
            Written on: <?php echo $post->created_at; ?>
        </div>

        <p class="card-text"><?php echo substr($post->body, 0, 250); ?></p>
        <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->id; ?>" class="btn btn-dark">More</a>
    </div>
<?php endforeach; ?>

<?php require APPROOT . '/views/includes/footer.php'; ?>
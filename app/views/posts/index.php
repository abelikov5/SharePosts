<?php require_once APPROOT . '/views/inc/header.php'?>
    <?php flash('post_message');?>
    <div class="row">
        <div class="col-md-6 mb-3">
            <h1>Posts</h1>
        </div>
        <div class="col-md-6">
            <a href="<?php echo URLROOT; ?>posts/add" class="btn btn-primary float-right">
                <i class="fa fa-pencil"></i> Add post
            </a>
        </div>
    </div>

    <?php foreach ($data["posts"] as $post) :?>
        <div class="card card-body mb-3">
            <h4 class="card-title"><?php echo $post->title?></h4>
            <div class="bg-light p3 mb-3">
                written by <b><?php echo $post->name; ?></b> on <?php echo $post->created; ?>.
            </div>
            <div class="card-text"><?php echo $post->body ?></div>
            <a href="<?php echo URLROOT ?>posts/show/<?php echo $post->postId; ?>" class="btn btn-dark">More info</a>
        </div>
    <?php endforeach; ?>

<?php require_once APPROOT . '/views/inc/footer.php'?>

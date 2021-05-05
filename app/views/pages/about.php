    <?php require_once APPROOT . '/views/inc/header.php'?>
        <div class="container">
            <h1><div class="display-3"><?php echo $data['title'];?></div></h1>
            <div class="lead"><?php echo $data['descr'];?></div>
            <p>Current version <strong><?php echo APPVERSION?></strong></p>
        </div>
    <?php require_once APPROOT . '/views/inc/footer.php'?>

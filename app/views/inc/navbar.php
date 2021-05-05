    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
        <div class="container">
            <a class="navbar-brand" href="<?php echo URLROOT?>"><?php echo SITENAME?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-item nav-link" href="<?php echo URLROOT?>">Home <span class="sr-only">(current)</span></a>
                    <a class="nav-item nav-link" href="<?php echo URLROOT . 'pages/about'?>">About</a>
                </div>
                <?php if(isset($_SESSION['user_id'])) : ?>
                    <div class="navbar-nav ml-auto">
                        <a class="nav-item nav-link" href="<?php echo URLROOT . 'users/profile'?>">Welcome, <?php echo ucwords($_SESSION['name']) ?> <span class="sr-only">(current)</span></a>
                        <a class="nav-item nav-link" href="<?php echo URLROOT . 'users/logout'?>">Logout</a>
                    </div>

                <?php else : ?>
                    <div class="navbar-nav ml-auto">
                        <a class="nav-item nav-link" href="<?php echo URLROOT . 'users/register'?>">Rigistration <span class="sr-only">(current)</span></a>
                        <a class="nav-item nav-link" href="<?php echo URLROOT . 'users/login'?>">Login</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

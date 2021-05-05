<?php
    /*
     * Bootstrap all necessary to start app;
     */
    // Load config file
    require_once '../app/config/config.php';
    require_once '../app/helpers/url_helper.php';
    require_once '../app/helpers/session_helper.php';

//    // Load libraries
//    require_once "../app/lib/Controller.php";
//    require_once '../app/lib/Core.php';
//    require_once '../app/lib/Database.php';

    // Autoload Core libraties
    spl_autoload_register(function ($className) {
        require_once '../app/lib/' . $className . '.php';
    });

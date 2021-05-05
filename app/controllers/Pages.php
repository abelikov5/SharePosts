<?php


class Pages extends Controller {
    function __construct () {
//        $this->postModel = $this->model('Post');
    }
    function index () {
//        print_r($_SESSION);
        if (isset($_SESSION['user_id'])) {
            redirect('posts');
        }
        $data = [
            'title' => 'SharePost app',
            'descr' => 'Simple social network application bilt on <a href="https://github.com/abelikov5/mvs_php">PHP MVC framework</a>',
//            'posts' => $this->postModel->getPosts(),
        ];
        $this->view('pages/index', $data);
//        echo 'index';
    }
    function about($arr) {
        $data = [
            'title' => 'About us',
            'descr' => 'Application to share posts with other users',
//            'posts' => $this->postModel->getPosts(),
        ];
        $this->view('pages/about', $data);
//        echo 'index';
    }
}
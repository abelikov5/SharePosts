<?php
    class Posts extends Controller {
        function __construct () {
            if(!isset($_SESSION['user_id'])) {
                redirect('users/login');
            }
            $this->postModel = $this->model("Post");
            $this->userModel = $this->model("User");
        }

        function index() {
            // Get posts
            $posts = $this->postModel->getPosts();
            $data = [
                'posts' => $posts,
            ];
            $this->view('posts/index', $data);
        }

        function add() {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'title'     => trim($_POST['title']),
                    'body'      => trim($_POST['body']),
                    'user_id'   => $_SESSION['user_id'],
                    'title_err' => '',
                    'body_err'  => ''
                ];
                // Validate title
                if(empty($data['title'])) {
                    $data['title_err'] = 'Please add title for your post';
                }
                if(empty($data['body'])) {
                    $data['body_err'] = 'Please add body for your post';
                }

                // Make sure no errors
                if(empty($data['title_err']) && empty($data['body_err'])) {
                    if($this->postModel->addPost($data)) {
                        flash('post_message', 'Post Added');
                        redirect('posts');
                    } else {
                        die('Some went wrong');
                    }

                } else {
                    // load view with errors
                    $this->view('posts/add', $data);
                }
            } else {
                // Get posts
                $posts = $this->postModel->getPosts();
                $data = [
                    'title' => '',
                    'body' => ''
                ];
                $this->view('posts/add', $data);
            }
        }

        function edit($id) {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'id'        => $id[0],
                    'title'     => trim($_POST['title']),
                    'body'      => trim($_POST['body']),
                    'user_id'   => $_SESSION['user_id'],
                    'title_err' => '',
                    'body_err'  => ''
                ];

                // Validate title
                if(empty($data['title'])) {
                    $data['title_err'] = 'Please add title for your post';
                }
                if(empty($data['body'])) {
                    $data['body_err'] = 'Please add body for your post';
                }

                // Make sure no errors
                if(empty($data['title_err']) && empty($data['body_err'])) {
                    if($this->postModel->updatePost($data)) {
                        flash('post_message', 'Post Updated');
                        redirect('posts');
                    } else {
                        die('Some went wrong');
                    }

                } else {
                    // load view with errors
                    $this->view('posts/edit', $data);
                }
            } else {
                // check for owner
                $post = $this->postModel->getPostById($id);
                if ($post->user_id != $_SESSION['user_id']) {
                    redirect('posts');

                }
                // Get posts
                $posts = $this->postModel->getPosts();
                $data = [
                    'id' => $id,
                    'title' => $post->title,
                    'body' => $post->body,
                ];
                $this->view('posts/edit', $data);
            }
        }

        function show ($id) {
            $post = $this->postModel->getPostById($id);
            $user = $this->userModel->getUserById($post->user_id);
//            var_dump($post[0]);

            $data = [
                'post' => $post,
                'user' => $user,
            ];

            $this->view('posts/show', $data);
        }

        function delete ($id) {
            if($_SERVER['REQUEST_METHOD'] == "POST") {
                if ($this->postModel->deletePost($id)) {
                    flash("post_message", "Post Removed");
                    redirect('posts');
                } else {
                    die('Something went wrong');
                }
            } else {
                redirect('posts');
            }

        }
    }

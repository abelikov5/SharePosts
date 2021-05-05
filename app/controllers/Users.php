<?php
    class Users extends Controller {
        function __construct () {
            $this->userModel = $this->model('User');
        }

        function profile () {
            $this->view('users/profile');
        }

        function register () {
            // Check for POST
            if($_SERVER['REQUEST_METHOD'] == "POST") {
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Process form
                $data = [
                    'name' => strtolower(trim($_POST['name'])),
                    'email' => strtolower(trim($_POST['email'])),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                // Validate Name
                if(empty($data['name'])) {
                    $data['name_err'] = 'Please enter your Name';
                }

                // Validate Email
                if(empty($data['email'])) {
                    $data['email_err'] = 'Please enter email';
                } else {
                    // Check email if exist
                    if($this->userModel->findUserByEmail($data['email'])) {
                        $data['email_err'] = 'Email exist';
                    }
                }

                // Validate Password
                if(empty($data['password'])) {
                    $data['password_err'] = 'Please enter email';
                } elseif (strlen($data['password']) < 6) {
                    $data['password_err'] = 'Password must be at least 6 characters';
                }

                // Validate Confirm Password
                if(empty($data['confirm_password'])) {
                    $data['confirm_password_err'] = 'Please enter confirm password';
                } else {
                    if ($data['password'] != $data['confirm_password']) {
                        $data['confirm_password_err'] = 'Passwords do not match';
                    }
                }

                // Make sure errors are empty
                if (empty($data['name_err']) && empty($data['password_err']) && empty($data['email_err']) && empty($data['confirm_password_err'])) {
                    // validated
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    if ($this->userModel->register($data)) {
                        flash('register_success', 'You are registered and can log in');
//                        echo "<pre>";
//                        print_r($_SESSION);
//                        echo "</pre>";
                        redirect('users/login');

                    } else {
                        die('something went wrong');
                    }


                } else {
                    $this->view('users/register', $data);
                }



            } else {
                // Init data
                $data = [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];
                // Load view
                $this->view('users/register', $data);
            }
        }

        function login () {
            // Check for POST
            if($_SERVER['REQUEST_METHOD'] == "POST") {
                // Process form
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Process form
                $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_err' => '',
                    'password_err' => '',
                ];

                // Validate email
                if(empty($data['email'])) {
                    $data['email_err'] = 'Please enter email';
                }

                // Validate Password
                if(empty($data['password'])) {
                    $data['password_err'] = 'Please enter password';
                } elseif (strlen($data['password']) < 6) {
                    $data['password_err'] = 'Please check password';
                }
                // Make sure errors are empty
                if (empty($data['password_err']) && empty($data['email_err'])) {
                    // validated
                    $validated = $this->userModel->login($data);
                    if (!$validated) {
                        $data['password_err'] = 'Email or password incorrect, please verify and try again';
                        $data['email_err'] = 'Email or password incorrect, please verify and try again';
                        $this->view('users/login', $data);
                        die('die false');
                    }
                    createSession($validated);
                    die('success');
                } else {
                    $this->view('users/login', $data);
                }
            } else {
                // Init data
                $data = [
                    'email' => '',
                    'password' => '',
                    'email_err' => '',
                    'password_err' => '',
                ];
                // Load view
                $this->view('users/login', $data);
            }
        }
        function logout() {
            unset($_SESSION['user_id']);
            unset($_SESSION['name']);
            unset($_SESSION['email']);
            session_destroy();
            redirect('pages/index');
        }
    }

function createSession($validated) {
    $_SESSION['user_id'] = $validated->id;
    $_SESSION['name'] = $validated->name;
    $_SESSION['email'] = $validated->mail;
    redirect('posts');
}



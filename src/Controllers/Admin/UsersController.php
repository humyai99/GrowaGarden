<?php

namespace Controllers\Admin;

use Core\Controller;

class UsersController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');

        // Middleware-like check for admin role
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
            // You can redirect to a 'not authorized' page or the homepage
            header('location: ' . URL_ROOT);
            exit();
        }
    }

    /**
     * List all users
     */
    public function index() {
        $users = $this->userModel->getAllUsers();

        $data = [
            'title' => 'User Management',
            'users' => $users
        ];

        // Note the path to the view, it's in an 'admin' subfolder
        $this->view('admin/users/index', $data);
    }

    public function create() {
        $data = [
            'title' => 'Create User',
            'username' => '',
            'full_name' => '',
            'email' => '',
            'password' => '',
            'role' => 'user',
            'department_id' => null,
            'errors' => []
        ];
        $this->view('admin/users/create', $data);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('location: ' . URL_ROOT . '/admin/users');
            exit();
        }

        $data = [
            'username' => trim($_POST['username']),
            'full_name' => trim($_POST['full_name']),
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'role' => trim($_POST['role']),
            'department_id' => !empty($_POST['department_id']) ? trim($_POST['department_id']) : null,
            'errors' => []
        ];

        // Validation
        if (empty($data['username'])) $data['errors']['username'] = 'Username is required.';
        if (empty($data['full_name'])) $data['errors']['full_name'] = 'Full name is required.';
        if (empty($data['email'])) $data['errors']['email'] = 'Email is required.';
        if (empty($data['password'])) $data['errors']['password'] = 'Password is required.';

        if (empty($data['errors'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            if ($this->userModel->createUser($data)) {
                header('location: ' . URL_ROOT . '/admin/users');
            } else {
                die('Something went wrong creating user.');
            }
        } else {
            $data['title'] = 'Create User';
            $this->view('admin/users/create', $data);
        }
    }

    public function edit($id) {
        $user = $this->userModel->findById($id);
        $data = [
            'title' => 'Edit User',
            'id' => $id,
            'username' => $user->username,
            'full_name' => $user->full_name,
            'email' => $user->email,
            'role' => $user->role,
            'department_id' => $user->department_id,
            'errors' => []
        ];
        $this->view('admin/users/edit', $data);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('location: ' . URL_ROOT . '/admin/users');
            exit();
        }

        $data = [
            'id' => $id,
            'full_name' => trim($_POST['full_name']),
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'role' => trim($_POST['role']),
            'department_id' => !empty($_POST['department_id']) ? trim($_POST['department_id']) : null,
            'errors' => []
        ];

        if (empty($data['full_name'])) $data['errors']['full_name'] = 'Full name is required.';
        if (empty($data['email'])) $data['errors']['email'] = 'Email is required.';

        if (empty($data['errors'])) {
            if (!empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            } else {
                // Keep old password, so don't include it in the data array for the model
                unset($data['password']);
            }

            if ($this->userModel->updateUser($data)) {
                header('location: ' . URL_ROOT . '/admin/users');
            } else {
                die('Something went wrong updating user.');
            }
        } else {
            $user = $this->userModel->findById($id);
            $data['title'] = 'Edit User';
            $data['username'] = $user->username;
            $this->view('admin/users/edit', $data);
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            header('location: ' . URL_ROOT . '/admin/users');
            exit();
        }

        // Add extra check to prevent deleting own account or user ID 1 (super admin)
        if ($id == $_SESSION['user_id'] || $id == 1) {
            // Redirect with an error message in a real app
            header('location: ' . URL_ROOT . '/admin/users');
            exit();
        }

        if ($this->userModel->deleteUser($id)) {
            header('location: ' . URL_ROOT . '/admin/users');
        } else {
            die('Something went wrong deleting user.');
        }
    }
}

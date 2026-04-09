<?php
class AuthController extends Controller {
    public function index() {
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']['role'] == 'admin') {
                $this->redirect('admin');
            } else {
                $this->redirect('user');
            }
        }
        $data['title'] = 'Login | Perpustakaan Digital';
        $this->view('auth/login', $data);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];

            $userModel = $this->model('User');
            $user = $userModel->getUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'fullname' => $user['fullname'],
                    'role' => $user['role'],
                    'avatar' => $user['avatar']
                ];

                if ($user['role'] == 'admin') {
                    $this->redirect('admin');
                } else {
                    $this->redirect('user');
                }
            } else {
                $_SESSION['flash'] = 'Username atau Password salah!';
                $this->redirect('auth');
            }
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $fullname = trim($_POST['fullname']);
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $confirm  = $_POST['confirm_password'];

            if ($password !== $confirm) {
                $_SESSION['flash'] = 'Konfirmasi password tidak cocok!';
                $this->redirect('auth/register');
                return;
            }

            $userModel = $this->model('User');
            $existing = $userModel->getUserByUsername($username);

            if ($existing) {
                $_SESSION['flash'] = 'Username sudah digunakan!';
                $this->redirect('auth/register');
                return;
            }

            $result = $userModel->addUser([
                'fullname' => $fullname,
                'username' => $username,
                'password' => $password,
                'role' => 'user'
            ]);

            if ($result > 0) {
                $_SESSION['success'] = 'Pendaftaran berhasil! Silakan login.';
                $this->redirect('auth');
            } else {
                $_SESSION['flash'] = 'Pendaftaran gagal. Coba lagi.';
                $this->redirect('auth/register');
            }
        } else {
            $data['title'] = 'Daftar Akun | Perpustakaan Digital';
            $this->view('auth/register', $data);
        }
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASEURL . '/auth');
        exit;
    }
}

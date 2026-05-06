<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $userModel = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'id'         => $user['id'],
                'username'   => $user['username'],
                'role'       => $user['role'],
                'isLoggedIn' => true,
            ]);

            return redirect()->to('/');
        }

        return redirect()->back()->with('error', 'Username atau password salah.');
    }

    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        return view('auth/register');
    }

    public function attemptRegister()
    {
        $userModel = new UserModel();

        $data = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'user',
        ];

        if ($userModel->insert($data)) {
            return redirect()->to('/login')->with('success', 'Registrasi berhasil. Silakan login.');
        }

        return redirect()->back()->withInput()->with('errors', $userModel->errors());
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}

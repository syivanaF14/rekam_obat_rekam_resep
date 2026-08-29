<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) {
            if (session()->get('role') === 'resepsionis') {
                return redirect()->to('/resepsionis');
            }
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Login',
        ];

        return view('auth/login', $data);
    }

    public function doLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = (new UserModel())->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'logged_in' => true,
                'user_id'   => $user['id'],
                'username'  => $user['username'],
                'role'      => $user['role'],
            ]);

            if ($user['role'] === 'resepsionis') {
                return redirect()->to('/resepsionis');
            }

            return redirect()->to('/dashboard');
        }

        return redirect()->back()->withInput()->with('error', 'Username atau password salah.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')->with('success', 'Anda berhasil logout.');
    }
}

<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Data User',
            'active' => 'users',
            'users'  => $this->userModel->orderBy('id', 'ASC')->findAll(),
        ];

        return view('users/index', $data);
    }

    public function create()
    {
        $data = [
            'title'  => 'Tambah User',
            'active' => 'users',
            'action' => site_url('users/store'),
            'user'   => null,
        ];

        return view('users/form', $data);
    }

    public function store()
    {
        if (!$this->validate($this->rules(false))) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->insert([
            'username' => $this->request->getPost('username'),
            'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
        ]);

        session()->setFlashdata('swal_success', 'User berhasil ditambahkan.');

        return redirect()->to('/users');
    }

    public function edit(int $id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'title'  => 'Edit User',
            'active' => 'users',
            'action' => site_url('users/update/' . $id),
            'user'   => $user,
        ];

        return view('users/form', $data);
    }

    public function update(int $id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan.');
        }

        $password = $this->request->getPost('password');

        if (!$this->validate($this->rules(true, $id))) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'role'     => $this->request->getPost('role'),
        ];

        if (!empty($password)) {
            $data['password'] = password_hash((string) $password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);

        session()->setFlashdata('swal_success', 'User berhasil diubah.');

        return redirect()->to('/users');
    }

    public function delete(int $id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan.');
        }

        if ($id === (int) session()->get('user_id')) {
            return redirect()->to('/users')->with('error', 'Tidak dapat menghapus akun yang sedang login.');
        }

        $this->userModel->delete($id);

        session()->setFlashdata('swal_success', 'User berhasil dihapus.');

        return redirect()->to('/users');
    }

    private function rules(bool $update = false, int $id = 0): array
    {
        $usernameRule = 'required|min_length[3]|max_length[100]';

        if ($update) {
            $usernameRule .= '|is_unique[users.username,id,' . $id . ']';
        } else {
            $usernameRule .= '|is_unique[users.username]';
        }

        return [
            'username' => $usernameRule,
            'password' => $update ? 'permit_empty|min_length[4]' : 'required|min_length[4]',
            'role'     => 'required|in_list[admin,apoteker,resepsionis]',
        ];
    }
}

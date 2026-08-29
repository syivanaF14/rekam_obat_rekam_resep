<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $role = session()->get('role');

        $allowedRoles = [];
        if ($arguments) {
            foreach ($arguments as $arg) {
                $allowedRoles = array_merge($allowedRoles, explode(',', $arg));
            }
            $allowedRoles = array_map('trim', $allowedRoles);
        }

        if (!$role || !in_array($role, $allowedRoles, true)) {
            $redirectUrl = $role === 'resepsionis' ? '/resepsionis' : '/dashboard';
            return redirect()->to($redirectUrl)->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}

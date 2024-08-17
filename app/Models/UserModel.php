<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'email', 'password', 'avatar'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'name' => 'required',
        'email' => 'required|valid_email',
        'password' => 'required',
        'avatar' => 'required'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Silahkan masukkan nama',
        ],
        'email' => [
            'required' => 'Email yang dimasukkan tidak valid',
        ],
        'password' => [
            'required' => 'Silahkan masukkan password',
        ],
        'avatar' => [
            'required' => 'Silahkan masukkan avatar',
        ],
    ];
}

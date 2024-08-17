<?php namespace App\Controllers;

use App\Models\UserModel;
use Throwable\Exception;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserController extends ResourceController
{
    use ResponseTrait;
    protected $modelName = 'App\Models\UserModel';
    protected $format    = 'json';

    private function generateJWT($userData)
    {
        $key = getenv('JWT_SECRET_KEY');
        $payload = [
            'iss' => base_url(), // Issuer
            'iat' => time(), // Issued at
            'nbf' => time(), // Not before
            'exp' => time() + 3600, // Expiration time (1 hour)
            'data' => $userData // Data to be encoded in the JWT
        ];

        return JWT::encode($payload, $key, getenv('JWT_ALGORITHM'));
    }

    private function validateJWT($token)
    {
        $key = getenv('JWT_SECRET_KEY');
        try {
            $decoded = JWT::decode($token, new Key($key, getenv('JWT_ALGORITHM')));
            return (array) $decoded->data;
        } catch (\Exception $e) {
            return null; // Invalid token
        }
    }

    public function login()
    {
        $model = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $user = $model->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            $jwt = $this->generateJWT(['id' => $user['id'], 'email' => $user['email']]);
            return $this->respond(['status' => 200, 'token' => $jwt], 200);
        } else {
            return $this->failUnauthorized('Invalid login credentials.');
        }
    }

    public function protectedRoute()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');
        if (empty($authHeader)) {
            return $this->failUnauthorized('Authorization header missing.');
        }
    
        $token = explode(' ', $authHeader)[1];
        $userData = $this->validateJWT($token);
    
        if (!$userData) {
            return $this->failUnauthorized('Invalid token.');
        }
    
        return $this->respond(['status' => 200, 'message' => 'Access granted', 'user' => $userData], 200);
    }
    
    public function index()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');
        if (empty($authHeader)) {
            return $this->failUnauthorized('Authorization header missing.');
        }
    
        $token = explode(' ', $authHeader)[1];
        $userData = $this->validateJWT($token);
    
        if (!$userData) {
            return $this->failUnauthorized('Invalid token.');
        }
    
        $users = $this->model->findAll();
        return $this->respond($users);
    }

    // public function show($id = null)
    // {
    //     $user = $this->model->find($id);
    //     if (!$user) {
    //         return $this->failNotFound('User not found');
    //     }
    //     return $this->respond($user);
    // }

    public function show($id = null)
{
    try {
        $user = $this->model->find($id);
        if (!$user) {
            return $this->failNotFound('User not found');
        }
        return $this->respond($user);
    } catch (\Exception $e) {
        log_message('error', $e->getMessage());
        return $this->failNotFound('User not found');
    }
}
    

    public function create()
    {
        $userModel = new UserModel();
        $data = $this->request->getPost();
    
        if (!$userModel->insert($data)) {
            return $this->fail($userModel->errors());
        }

        return $this->respondCreated([
            'status' => 201,
            'message' => 'Data berhasil ditambahkan',
            'data' => $data,
        ]);

    }
    
    public function update($id = null)
    {
        $model = new UserModel();
        $data = $this->request->getJSON();
        $user = $model->find($id);
        if (!$user) {
            return $this->failNotFound('User not found');
        }
    
        if (!$model->update($id, $data)) {
            return $this->fail($model->errors());
        }
    
        return $this->respondUpdated([
            'status' => 200,
            'message' => 'User updated successfully',
            'data' => $data
        ]);
    }

    public function delete($id = null)
    {
        $user = new UserModel();
        $user->delete($id);
        return $this->respondDeleted(['id dihapus' => $id]);
    }
}

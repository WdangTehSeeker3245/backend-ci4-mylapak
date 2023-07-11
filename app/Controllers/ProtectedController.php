<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\UserModel;

class ProtectedController extends ResourceController
{
    use ResponseTrait;

    public function __construct()
    {
        $this->privateKey = env('JWT_PRIVATE_KEY');
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        $headerParts = explode(' ',$header);
        $accessToken = $headerParts[1];
        try {
            $decoded = JWT::decode($accessToken, new Key($this->privateKey, 'HS256'));
            $userId = $decoded->user_id;
        } catch (\Exception $e) {
            return $this->failUnauthorized('Invalid access token');
        }


        $user = $this->userModel->find($userId);

        if ($user === null) {
            return $this->failNotFound('User not found');
        }

        $response = [
            'user_id' => $userId,
            'username' => $user['username'],
            'fullname' => $user['fullname']
        ];

        return $this->respond($response);
    }
}

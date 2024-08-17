<?php

// use Firebase\JWT\JWT;
// use Firebase\JWT\Key;
// use Config\Services;

// // Fungsi untuk mendapatkan JWT dari header Authorization
// function getJWT($authHeader)
// {
//     if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
//         return $matches[1];
//     }
//     throw new Exception('Missing or invalid JWT in Authorization header');
// }

// // Fungsi untuk memvalidasi JWT
// function validateJWT($encodedToken)
// {
//     $key = getenv('JWT_SECRET_KEY');
//     $decoded = JWT::decode($encodedToken, new Key($key, getenv('JWT_ALGORITHM')));
    
//     if (!$decoded) {
//         throw new Exception('Invalid JWT token');
//     }
    
//     return $decoded;
// }

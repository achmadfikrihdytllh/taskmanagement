<?php

// namespace App\Filters;

// use CodeIgniter\Filters\FilterInterface;
// use CodeIgniter\HTTP\RequestInterface;
// use CodeIgniter\HTTP\ResponseInterface;
// use CodeIgniter\API\ResponseTrait;
// use Exception;
// use Config\Services;

// class FilterJwt implements FilterInterface
// {
//     use ResponseTrait;

//     public function before(RequestInterface $request, $arguments = null)
//     {
//         log_message('debug', 'FilterJwt dijalankan secara global');
        
//         // Cek apakah request memiliki header Authorization
//         $header = $request->getServer('HTTP_AUTHORIZATION');
//         log_message('debug', 'Authorization Header: ' . print_r($header, true));
    
//         // Jika tidak ada header, skip proses lebih lanjut
//         if (empty($header)) {
//             log_message('debug', 'Tidak ada Authorization header, melewati filter.');
//             return;
//         }
    
//         try {
//             helper('jwt');
//             $encodedToken = getJWT($header);
//             validateJWT($encodedToken);
//             return $request;
    
//         } catch (Exception $e) {
//             log_message('error', 'Otentikasi gagal: ' . $e->getMessage());
//             return Services::response()->setJSON(
//                 [
//                     'error' => $e->getMessage()
//                 ]
//             )->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
//         }
//     }
    
    
    

//     public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
//     {

//     }
// }


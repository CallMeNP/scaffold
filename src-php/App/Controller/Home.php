<?php


namespace App\Controller;


use App\Core\Core;
use App\Core\Service;
use App\Service\Helper\File;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;

class Home
{
    public function __construct()
    {
    }

    public function index(RequestInterface $request, ResponseInterface $response, $args)
    {
        return $response;
    }

}

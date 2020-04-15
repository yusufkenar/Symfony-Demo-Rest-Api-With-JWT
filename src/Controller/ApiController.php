<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @return JsonResponse
     */
    public function index()
    {
        return $this->responseWithSuccess('Welcome '.$_ENV['APP_NAME']);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param  int  $statusCode
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function response($data)
    {
        return new JsonResponse($data, $this->getStatusCode());
    }

    /**
     * @param  string  $success
     * @return JsonResponse
     */
    public function responseWithSuccess(string $success)
    {
        $data = [
            'status' => $this->getStatusCode(),
            'success' => $success,
        ];

        return new JsonResponse($data, $this->getStatusCode());
    }

    /**
     * @param  string  $error
     * @return JsonResponse
     */
    public function responseWithError(string $error)
    {
        $this->setStatusCode(422);
        $data = [
            'status' => $this->getStatusCode(),
            'errors' => $error,
        ];

        return new JsonResponse($data, $this->getStatusCode());
    }

    /**
     * @param  array  $errors
     * @return JsonResponse
     */
    public function responseWithErrors(array $errors)
    {
        $data = [
            'status' => $this->getStatusCode(),
            'errors' => $errors,
        ];

        return new JsonResponse($data, $this->getStatusCode());
    }

    public function responseUnauthorized($message = 'Unauthorized.')
    {
        $this->setStatusCode(401);

        return $this->responseWithError($message);
    }

    protected function transformJsonBody(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}
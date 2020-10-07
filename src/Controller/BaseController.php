<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationList;

class BaseController extends AbstractController
{
    protected function createErrorsResponse(
        ConstraintViolationList $errors
    ): JsonResponse {
        $errorsResponse = [];

        foreach ($errors as $error) {
            $errorsResponse[] = [
                'title' => $error->getPropertyPath(),
                'message' => $error->getMessage(),
            ];
        }

        return $this->json(
            [ 'errors' => $errorsResponse ],
            JsonResponse::HTTP_BAD_REQUEST
        );
    }
}

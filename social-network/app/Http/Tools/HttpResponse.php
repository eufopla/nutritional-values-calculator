<?php

namespace App\Http\Tools;

use Illuminate\Http\Response;

class HttpResponse
{
    public static function getResponse(int $code, string $message, $data = [], bool $asObject = false): Response
    {
        $response = new Response();

        $data = $asObject ? (object) $data : $data;

        $content = [
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];

        return $response
            ->setContent($content)
            ->setStatusCode($code);
    }


    public static function getResponseObject(int $code, string $message, object $data): Response
    {
        $response = new Response();
        $content = [
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];

        return $response
            ->setContent($content)
            ->setStatusCode($code);
    }

    public static function getArrayResponse(array $array = []): Response
    {
        $response = new Response();

        return $response
            ->setContent($array)
            ->setStatusCode(200);
    }

    public static function getValidatorResponse(array $errors, string $message = null): Response
    {
        $response = new Response();
        $content = [
            'code' => 400,
            'message' => 'Une erreur s\'est produite. Merci de vérifier les champs en rouge.',
            'errors' => $errors
        ];

        if (isset($message)) {
            $content['message'] = $message;
        }

        return $response
            ->setContent($content)
            ->setStatusCode(400);
    }
}

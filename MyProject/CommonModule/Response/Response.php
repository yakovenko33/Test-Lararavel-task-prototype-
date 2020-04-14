<?php


namespace MyProject\CommonModule\Response;


use MyProject\CommonModule\CommonHandler\Interfaces\ResultHandlerInterface;
use \Illuminate\Http\JsonResponse;

trait Response
{
    /**
     * @param ResultHandlerInterface $resultHandler
     * @return JsonResponse
     */
    protected function getResponse(ResultHandlerInterface $resultHandler): JsonResponse
    {
        $hasErrors = $resultHandler->hasErrors();

        return response()->json([
            "data" => $hasErrors ? $resultHandler->getErrors() : $resultHandler->getResult(),
            'status' => $hasErrors ? 'errors' : 'success'
        ], $resultHandler->getCode());
    }
}

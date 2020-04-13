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
        if ($resultHandler->hasErrors()) {
            return response()->json([
                "data" => $resultHandler->getErrors(),
                'status' => 'errors'
            ], $resultHandler->getCodeError());
        }

        return response()->json([
            "data" => $resultHandler->getResult(),
            'status' => 'success'
        ], 200);
    }
}

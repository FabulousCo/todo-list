<?php

namespace ApiBundle\Transformer;

use Symfony\Component\HttpFoundation\JsonResponse;

abstract class BaseTransformer
{
    private $response;

    public function __construct($data)
    {
        if (is_array($data)) {
            $this->response = $this->collection($data);
        } else {
            $this->response = $this->transform($data);
        }
    }

    public function collection($collection)
    {
        $response = [];

        foreach($collection as $item) {
            $response[] = $this->transform($item);
        }

        return $response;
    }

    abstract function transform($item);

    public function response($status = 200)
    {
        return new JsonResponse($this->response, $status);
    }
}

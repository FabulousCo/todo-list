<?php

namespace AppBundle\Transformer;

abstract class BaseTransformer
{
    public function collection($collection)
    {
        $response = [];

        foreach($collection as $item) {
            $response[] = $this->transform($item);
        }

        return $response;
    }

    abstract function transform($item);
}

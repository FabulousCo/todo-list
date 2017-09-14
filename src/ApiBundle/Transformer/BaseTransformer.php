<?php

namespace ApiBundle\Transformer;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class BaseTransformer
 * @package ApiBundle\Transformer
 */
abstract class BaseTransformer
{
    /**
     * @var
     */
    private $response;

    /**
     * BaseTransformer constructor.
     * @param $data
     */
    public function __construct($data)
    {
        if (is_array($data) || $data instanceof \Doctrine\ORM\PersistentCollection) {
            $this->response = $this->collection($data);
        } else {
            $this->response = $this->transform($data);
        }
    }

    /**
     * @param $collection
     * @return array
     */
    public function collection($collection)
    {
        $response = [];

        foreach($collection as $item) {
            $response[] = $this->transform($item);
        }

        return $response;
    }

    /**
     * @param $item
     * @return mixed
     */
    abstract function transform($item);

    /**
     * @param int $status
     * @return JsonResponse
     */
    public function response($status = 200)
    {
        return new JsonResponse($this->response, $status);
    }
}

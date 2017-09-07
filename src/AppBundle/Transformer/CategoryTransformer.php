<?php

namespace AppBundle\Transformer;

use AppBundle\Entity\Category;

class CategoryTransformer extends BaseTransformer
{
    public function __construct($data)
    {
        if ($data instanceof Category) {
            return $this->transform($data);
        }

        return $this->collection($data);
    }

    public function transform($category)
    {
        return [
            'id' => $category->getId(),
            'name' => $category->getName()
        ];
    }
}

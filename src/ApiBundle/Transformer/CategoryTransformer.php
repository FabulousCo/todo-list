<?php

namespace ApiBundle\Transformer;

class CategoryTransformer extends BaseTransformer
{
    public function transform($category)
    {
        return [
            'id' => $category->getId(),
            'name' => $category->getName(),
            'created' => ($category->getCreated() ? $category->getCreated()->format('Y-m-d H:i:s') : null),
            'modified' => ($category->getModified() ? $category->getModified()->format('Y-m-d H:i:s') : null),
        ];
    }
}

<?php

namespace ApiBundle\Transformer;

class TodoTransformer extends BaseTransformer
{
    public function transform($todo)
    {
        return [
            'id' => $todo->getId(),
            'title' => $todo->getTitle(),
            'category' => new CategoryTransformer($todo->getCategories()),
            'created' => ($todo->getCreated() ? $todo->getCreated()->format('Y-m-d H:i:s') : null),
            'modified' => ($todo->getModified() ? $todo->getModified()->format('Y-m-d H:i:s') : null),
            'categories' => new CategoryTransformer($todo->getCategories())
        ];
    }
}

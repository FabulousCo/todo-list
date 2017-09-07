<?php

namespace AppBundle\Transformer;

use AppBundle\Entity\Todo;

class TodoTransformer
{
    public function __construct($data)
    {
        if ($data instanceof Todo) {
            return $this->transform($data);
        }

        return $this->collection($data);
    }

    public function transform(Todo $todo)
    {
        return [
            'id' => $todo->getId(),
            'title' => $todo->getTitle(),
            'category' => new CategoryTransformer($todo->getCategories())
        ];
    }
}

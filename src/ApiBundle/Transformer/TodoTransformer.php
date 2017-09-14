<?php

namespace ApiBundle\Transformer;

/**
 * Class TodoTransformer
 * @package ApiBundle\Transformer
 */
class TodoTransformer extends BaseTransformer
{
    /**
     * @param $todo
     * @return array
     */
    public function transform($todo)
    {
        return [
            'id' => $todo->getId(),
            'title' => $todo->getTitle(),
            'status' => $todo->getStatus(),
            'done' => $todo->getStatus() === 'done',
            'created' => ($todo->getCreated() ? $todo->getCreated()->format('Y-m-d H:i:s') : null),
            'modified' => ($todo->getModified() ? $todo->getModified()->format('Y-m-d H:i:s') : null),
            'categories' => new CategoryTransformer($todo->getCategories())
        ];
    }
}

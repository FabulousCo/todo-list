<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\Category;
use ApiBundle\Entity\Todo;
use ApiBundle\Transformer\TodoTransformer;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class TodoController
 * @package ApiBundle\Controller
 */
class TodoController extends BaseController
{
    /**
     * Get a collection of all the existing todos
     *
     * @return JsonResponse
     */
    public function indexAction()
    {
        $todos = $this->getRepo(Todo::class)->findAll();

        return (new TodoTransformer($todos))->response(200);
    }

    /**
     * Create a todo with the data sent in the request
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function storeAction(Request $request)
    {
        $todo = new Todo();
        $todo->setTitle($request->request->get('title'));
        $categories = $request->request->get('categories');

        foreach ($categories as $categoryId) {
            $category = $this->getRepo(Category::class)->find($categoryId);

            $todo->addCategory($category);
        }

        $validator = $this->get('validator');
        $errors = $validator->validate($todo);

        if (count($errors) > 0) {
            return new JsonResponse(['message' => (string) $errors], 422);
        }

        $this->getEm()->persist($todo);
        $this->getEm()->flush();

        return (new TodoTransformer($todo))->response(201);
    }

    /**
     * Show the todo having the id given in param
     *
     * @param $id
     * @return JsonResponse
     */
    public function showAction($id)
    {
        $todo = $this->getRepo(Todo::class)->find($id);

        if (! $todo) {
            return new JsonResponse([], 404);
        }

        return (new TodoTransformer($todo))->response(200);
    }

    /**
     * Update the todo having the id given in param
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateAction(Request $request, $id)
    {
        $todo = $this->getRepo(Todo::class)->find($id);

        if (! $todo) {
            return new JsonResponse([], 404);
        }

        $todo->setTitle($request->request->get('title'));
        $todo->setModified(Carbon::now());

        $categories = $request->request->get('categories');

        foreach ($categories as $categoryId) {
            $category = $this->getRepo(Category::class)->find($categoryId);

            $todo->addCategory($category);
        }

        $validator = $this->get('validator');
        $errors = $validator->validate($todo);

        if (count($errors) > 0) {
            return new JsonResponse(['message' => (string) $errors], 422);
        }

        $this->getEm()->persist($todo);
        $this->getEm()->flush();

        return (new TodoTransformer($todo))->response(200);
    }

    /**
     * Delete the todo having the id given in param
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroyAction($id)
    {
        $todo = $this->getRepo(Todo::class)->find($id);

        if (! $todo) {
            return new JsonResponse([], 404);
        }

        $this->getEm()->remove($todo);
        $this->getEm()->flush();

        return new JsonResponse([], 204);
    }
}

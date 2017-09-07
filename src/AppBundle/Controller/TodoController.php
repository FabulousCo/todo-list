<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Todo;
use AppBundle\Transformer\TodoTransformer;
use Carbon\Carbon;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class TodoController extends BaseController
{
    public function indexAction()
    {
        $todos = $this->getRepo(Todo::class)->findAll();

        return new JsonResponse(new TodoTransformer($todos), 200);
    }

    public function storeAction(Request $request)
    {
        $todo = new Todo();
        $todo->setName($request->request->get('name'));
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

        return new JsonResponse(new TodoTransformer($todo), 200);
    }

    public function showAction($id)
    {
        $todo = $this->getRepo(Todo::class)->find($id);

        if (! $todo) {
            return new JsonResponse([], 404);
        }

        return new JsonResponse(new TodoTransformer($todo), 200);
    }

    public function updateAction(Request $request, $id)
    {
        $todo = $this->getRepo(Todo::class)->find($id);

        if (! $todo) {
            return new JsonResponse([], 404);
        }

        $todo->setName($request->request->get('name'));
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

        return new JsonResponse(new TodoTransformer($todo), 200);
    }

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

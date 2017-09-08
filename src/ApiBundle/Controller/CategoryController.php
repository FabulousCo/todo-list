<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\Category;
use ApiBundle\Transformer\CategoryTransformer;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends BaseController
{
    public function indexAction()
    {
        $categories = $this->getRepo(Category::class)->findAll();

        return (new CategoryTransformer($categories))->response(200);
    }

    public function storeAction(Request $request)
    {
        $category = new Category();
        $category->setName($request->request->get('name'));

        $validator = $this->get('validator');
        $errors = $validator->validate($category);

        if (count($errors) > 0) {
            return new JsonResponse(['message' => (string) $errors], 422);
        }

        $this->getEm()->persist($category);
        $this->getEm()->flush();

        return (new CategoryTransformer($category))->response(201);
    }

    public function showAction($id)
    {
        $category = $this->getRepo(Category::class)->find($id);

        if (! $category) {
            return new JsonResponse([], 404);
        }

        return (new CategoryTransformer($category))->response(200);
    }

    public function updateAction(Request $request, $id)
    {
        $category = $this->getRepo(Category::class)->find($id);

        if (! $category) {
            return new JsonResponse([], 404);
        }

        $category->setName($request->request->get('name'));
        $category->setModified(Carbon::now());

        $validator = $this->get('validator');
        $errors = $validator->validate($category);

        if (count($errors) > 0) {
            return new JsonResponse(['message' => (string) $errors], 422);
        }

        $this->getEm()->persist($category);
        $this->getEm()->flush();

        return (new CategoryTransformer($category))->response(200);
    }

    public function destroyAction($id)
    {
        $category = $this->getRepo(Category::class)->find($id);

        if (! $category) {
            return new JsonResponse([], 404);
        }

        $this->getEm()->remove($category);
        $this->getEm()->flush();

        return new JsonResponse([], 204);
    }
}

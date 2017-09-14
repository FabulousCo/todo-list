<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\Category;
use ApiBundle\Transformer\CategoryTransformer;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryController
 * @package ApiBundle\Controller
 */
class CategoryController extends BaseController
{
    /**
     * Get a collection of all the existing categories
     *
     * @return JsonResponse
     */
    public function indexAction()
    {
        $categories = $this->getRepo(Category::class)->findAll();

        return (new CategoryTransformer($categories))->response(200);
    }

    /**
     * Create a category with the data sent in the request
     *
     * @param Request $request
     * @return JsonResponse
     */
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

    /**
     * Show the category having the id given in param
     *
     * @param $id
     * @return JsonResponse
     */
    public function showAction($id)
    {
        $category = $this->getRepo(Category::class)->find($id);

        if (! $category) {
            return new JsonResponse([], 404);
        }

        return (new CategoryTransformer($category))->response(200);
    }

    /**
     * Update the category having the id given in param
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
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

    /**
     * Delete the category having the id given in param
     *
     * @param $id
     * @return JsonResponse
     */
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

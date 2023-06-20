<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Service\MealService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MealsController extends AbstractController
{
    private $entityManager;
    private $mealService;
    private $categoryRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        MealService $mealService,
        CategoryRepository $categoryRepository
    ) {
        $this->entityManager = $entityManager;
        $this->mealService = $mealService;
        $this->categoryRepository = $categoryRepository;
    }

    #[Route('/meals', name: 'meals')]
    public function index(Request $request): Response
    {
        // dd(Date('Y-m-d', 1000000));
        $perPage = $request->query->getInt('per_page', 4);
        $page = $request->query->getInt('page', 1);
        $categoryId = $request->query->getInt('category', 0);
        $tagsUrl = $request->query->get('tags', '');
        $with = $request->query->get('with', '');
        $lang = $request->query->get('lang', 'en');
        $diff_time = $request->query->getInt('diff_time', 0);

        $withArray = explode(',', $with);
        $withArray = array_map('trim', $withArray);

        $tagIds = array_map('intval', explode(',', $tagsUrl));
        $tagIds = array_filter($tagIds);

        // izracunaj broj ukupnih jela
        $totalMeals = $this->mealService->getTotalMealCount($categoryId, $tagIds, $diff_time);
        $totalPages = $this->mealService->getTotalPages($totalMeals, $perPage);

        // query za biranje svih jela
        $meals = $this->mealService->getFilteredMeals($categoryId, $tagIds, $page, $perPage, $lang, $diff_time);

        // formatiranje json data
        $jsonResponse = $this->mealService->convertMealsToJson($meals, $withArray, $page, $perPage, $totalPages, $totalMeals);

        return $jsonResponse;

        // donji return je za front end

        // return $this->render('meals/index.html.twig', [
        //     'controller_name' => 'MealsController',
        //     'meals' => $meals,
        //     'page' => $page,
        //     'per_page' => $perPage,
        //     'total_pages' => $totalPages,
        //     'total_meals' => $totalMeals,
        //     'category' => $categoryId,
        //     'categories' => $this->categoryRepository->findAll(),
        //     'with' => $with,
        //     'tags' => $tagsUrl,
        //     'lang' => $lang,
        // ]);
    }
}

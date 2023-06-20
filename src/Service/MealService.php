<?php
// src/Service/MealService.php

namespace App\Service;

use App\Repository\MealRepository;
use App\Repository\CategoryRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class MealService
{
    private $entityManager;
    private $mealRepository;
    private $categoryRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        MealRepository $mealRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->entityManager = $entityManager;
        $this->mealRepository = $mealRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function getTotalMealCount(int $categoryId, array $tagIds, int $diff_time): int
    {
        $totalMeals = $this->mealRepository->createQueryBuilder('m')
            ->select('COUNT(m.id)');

        if ($categoryId > 0) {
            $category = $this->categoryRepository->find($categoryId);
            if ($category) {
                $totalMeals->andWhere('m.category = :category')
                    ->setParameter('category', $category);
            }
        }

        if (!empty($tagIds)) {
            foreach ($tagIds as $index => $tagId) {
                $totalMeals
                    ->join('m.tags', 't' . $index)
                    ->andWhere('t' . $index . '.id = :tag' . $index)
                    ->setParameter('tag' . $index, $tagId);
            }
        }
        if ($diff_time>0) {
            $totalMeals
                ->andWhere($totalMeals->expr()->orX(
                    $totalMeals->expr()->isNull('m.deletedAt'),
                    $totalMeals->expr()->gt('m.deletedAt', ':date')
                ))
                ->setParameter('date', date('Y-m-d', $diff_time));
        }
        else {
            $totalMeals
                ->andWhere($totalMeals->expr()->isNull('m.deletedAt'));
        }
        


        return $totalMeals->getQuery()->getSingleScalarResult();
    }

    public function getTotalPages(int $totalMeals, int $perPage): int
    {
        return ceil($totalMeals / $perPage);
    }

    public function getFilteredMeals(int $categoryId, array $tagIds, int $page, int $perPage, string $lang, int $diff_time): array
    {
        $query = $this->mealRepository->createQueryBuilder('m');

        if ($categoryId > 0) {
            $category = $this->categoryRepository->find($categoryId);
            if ($category) {
                $query->andWhere('m.category = :category')
                    ->setParameter('category', $category);
            }
        }

        if (!empty($tagIds)) {
            foreach ($tagIds as $index => $tagId) {
                $query
                    ->join('m.tags', 't' . $index)
                    ->andWhere('t' . $index . '.id = :tag' . $index)
                    ->setParameter('tag' . $index, $tagId);
            }
        }
        if ($diff_time>0) {
            $query
                ->andWhere($query->expr()->orX(
                    $query->expr()->isNull('m.deletedAt'),
                    $query->expr()->gt('m.deletedAt', ':date')
                ))
                ->setParameter('date', date('Y-m-d', $diff_time));
        }
        else {
            $query
                ->andWhere($query->expr()->isNull('m.deletedAt'));
        }

        $query->setMaxResults($perPage);
        $query->setFirstResult(($page - 1) * $perPage);

        $meals = $query->getQuery()->getResult();

        if ($lang === 'hr') {
            foreach ($meals as $meal) {
                $category = $meal->getCategory();
                $tags = $meal->getTags();
                $ingredients = $meal->getIngredients();

                foreach ($tags as $tag) {
                    $tag->setTitle($tag->getTranslations()[0]->getTitle());
                }

                foreach ($ingredients as $ingredient) {
                    $ingredient->setTitle($ingredient->getTranslations()[0]->getTitle());
                }

                $category->setTitle($category->getTranslations()[0]->getTitle());
                $meal->setTitle($meal->getTranslations()[0]->getTitle());
                $meal->setDescription($meal->getTranslations()[0]->getDescription());
            }
        }

        return $meals;
    }

    public function convertMealsToJson(array $meals, array $withArray, int $page, int $perPage, int $totalPages, int $totalMeals): JsonResponse
    {
        $responseData = [];
        $metaData = [
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => $totalPages,
            'total_items' => $totalMeals,
        ];
        $mealsData = [];

        foreach ($meals as $meal) {
            $mealData = [
                'id' => $meal->getId(),
                'title' => $meal->getTitle(),
                'description' => $meal->getDescription(),
            ];

            $status = 'created';
            if ($meal->getDeletedAt()!=null) {
                $status = 'deleted';
            }
            $mealData['status'] = $status;

            

            if (in_array('ingredients', $withArray)) {
                $ingredients = $meal->getIngredients();
                $ingredientsData = [];
                foreach ($ingredients as $ingredient) {
                    $ingredientsData[] = [
                        'id' => $ingredient->getId(),
                        'title' => $ingredient->getTitle(),
                        'slug' => $ingredient->getSlug()
                    ];
                }
                $mealData['ingredients'] = $ingredientsData;
            }

            if (in_array('category', $withArray)) {
                $category = $meal->getCategory();
                $mealData['category'] = [
                    'id' => $category->getId(),
                    'title' => $category->getTitle(),
                    'slug' => $category->getSlug()
                ];
            }

            if (in_array('tags', $withArray)) {
                $tags1 = $meal->getTags();
                $tagsData = [];
                foreach ($tags1 as $tag) {
                    $tagsData[] = [
                        'id' => $tag->getId(),
                        'title' => $tag->getTitle(),
                        'slug' => $tag->getSlug()
                    ];
                }
                $mealData['tags'] = $tagsData;
            }

            $mealsData[] = $mealData;
        }

        $responseData['meta'] = $metaData;
        $responseData['data'] = $mealsData;

        $jsonResponse = new JsonResponse($responseData);
        $jsonResponse->setEncodingOptions(JSON_PRETTY_PRINT);

        return $jsonResponse;
    }
}

?>

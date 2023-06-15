<?php

namespace App\Controller;

use Faker\Factory;
use App\Entity\Tag;
use App\Entity\Meal;
use App\Entity\Category;
use App\Entity\Ingredient;
use App\Entity\TagTranslation;
use App\Repository\TagRepository;
use App\Repository\MealRepository;
use App\Entity\CategoryTranslation;
use App\Entity\IngredientTranslation;
use App\Entity\MealTranslation;
use App\Repository\CategoryRepository;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MealsController extends AbstractController
{
    private $entityManager;
    private $ingredientRepository;
    private $categoryRepository;
    private $tagRepository;
    private $mealRepository;

    public function __construct(
        EntityManagerInterface $entityManager, 
        IngredientRepository $ingredientRepository,
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository,
        MealRepository $mealRepository
        )
    {
        $this->entityManager = $entityManager;
        $this->ingredientRepository = $ingredientRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->mealRepository = $mealRepository;
    }
    #[Route('/meals', name: 'meals')]
    public function index(Request $request, SerializerInterface $serializer): Response
    {
        $perPage = $request->query->getInt('per_page', 4);
        $page = $request->query->getInt('page', 1); 
        $categoryId = $request->query->getInt('category', 0); 
        $tagsUrl = $request->query->get('tags', ''); 
        $with = $request->query->get('with', '');
        $lang = $request->query->get('lang', 'en');

        $withArray = explode(',', $with);
        $withArray = array_map('trim', $withArray);
       
        $tagIds = array_map('intval', explode(',', $tagsUrl));
        $tagIds = array_filter($tagIds); 

        //izracunaj broj ukupnih jela

        $totalMeals = $this->mealRepository->createQueryBuilder('m')
        ->select('COUNT(m.id)');


        if ($categoryId>0) {
            $category = $this->categoryRepository->find($categoryId);
            if ($category) {
                $totalMeals->andWhere('m.category = :category')
                    ->setParameter('category', $category);
            }
        }
        if (!empty($tagIds)) {
            foreach ($tagIds as $index => $tagId) {
                $totalMeals
                    ->join('m.tags', 't'.$index)
                    ->andWhere('t'.$index.'.id = :tag'.$index)
                    ->setParameter('tag'.$index, $tagId);
            }
        }
        $totalMeals = $totalMeals        
        ->getQuery()
        ->getSingleScalarResult();
        
        // izracunaj broj ukupnih stranica prema broju jela i perPage

        $totalPages = ceil($totalMeals / $perPage);

        // query za biranje svih jela

        $query = $this->mealRepository->createQueryBuilder('m');
        if ($categoryId>0) {
            $category = $this->categoryRepository->find($categoryId);
            if ($category) {
                $query->andWhere('m.category = :category')
                    ->setParameter('category', $category);
            }
        }
        if (!empty($tagIds)) {
            foreach ($tagIds as $index => $tagId) {
                $query
                    ->join('m.tags', 't'.$index)
                    ->andWhere('t'.$index.'.id = :tag'.$index)
                    ->setParameter('tag'.$index, $tagId);
            }
        }
        $query->setMaxResults($perPage);
        $query->setFirstResult(($page - 1) * $perPage);
        $meals = $query->getQuery()->getResult();

        // parametar jezika u slucaju da je hrvatski

        if ($lang == 'hr') {
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
                $category->setTitle(($category->getTranslations()[0]->getTitle()));
                $meal->setTitle($meal->getTranslations()[0]->getTitle());
                $meal->setDescription($meal->getTranslations()[0]->getDescription());

            }
        }
        
        //formatiranje json data

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
    
        // return $jsonResponse;

        // 
        // gornji return je za JSON response
        // ovaj dolje return je za front end umjesto JSON-a
        // 


        return $this->render('meals/index.html.twig', [
            'controller_name' => 'MealsController',
            'meals' => $meals,
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => $totalPages,
            'total_meals' => $totalMeals,
            'category' => $categoryId,
            'categories' => $this->categoryRepository->findAll(),
            'with' => $with,
            'tags' => $tagsUrl,
            'lang' => $lang,
        ]);
    
    }





    
    #[Route('/meals/create_data', name: 'create_data')]
    public function create_data(): Response
    {
        $faker = Factory::create();

        for ($i = 10; $i < 11; $i++) {
            
            $fakeName = $faker->word();
            ////////////
            //HARDCODED DATA
            ////////////

                    //ingredient random data

            // $ingredient = new Ingredient();
            // $ingredient->setTitle($fakeName);
            // $ingredient->setSlug($fakeName);
            // $this->entityManager->persist($ingredient);

            
                    //tag random data

            // $tag = new Tag();
            // $tag->setTitle('TAG'.strval($i));
            // $tag->setSlug('tag-'.strval($i));
            // $this->entityManager->persist($tag);

                    //category random data

            // $category = new Category();
            // $category->setTitle('CATEGORY'.strval($i));
            // $category->setSlug('cat-'.strval($i));
            // $this->entityManager->persist($category);

                    //category translation random data

            // $translation = new CategoryTranslation();
            // $translation->setLocale('en');
            // $translation->setCategory($this->categoryRepository->find($i));
            // $translation->setTitle('CATEGORY'.strval($i));
            // $translation->setSlug('cat-'.strval($i));
            // $this->entityManager->persist($translation);

                    //tag translation random data

            // $translation = new TagTranslation();
            // $translation->setLocale('hr');
            // $translation->setTag($this->tagRepository->find($i));
            // $translation->setTitle('HRVtag'.strval($i));
            // $this->entityManager->persist($translation);

                    //ingredient translation random data

            // $translation = new IngredientTranslation();
            // $translation->setLocale('hr');
            // $translation->setIngredient($this->ingredientRepository->find($i));
            // $translation->setTitle('HRV'.$this->ingredientRepository->find($i)->getTitle());
            // $this->entityManager->persist($translation);

                    //meal translation random data

            // $translation = new MealTranslation();
            // $translation->setLocale('hr');
            // $translation->setMeal($this->mealRepository->find($i));
            // $translation->setTitle('HRV'.$this->mealRepository->find($i)->getTitle());
            // $translation->setDescription('HRV'.$this->mealRepository->find($i)->getDescription());
            // $this->entityManager->persist($translation);

                    // random meal data

            // $meal = new Meal();
            // $meal->setTitle($faker->words(2, true));
            
            // $meal->addIngredient($this->ingredientRepository->getRandomIngredient());
            // $meal->addIngredient($this->ingredientRepository->getRandomIngredient());
            // $meal->addIngredient($this->ingredientRepository->getRandomIngredient());
    
            // $meal->addTag($this->tagRepository->getRandomTag());
            // $meal->addTag($this->tagRepository->getRandomTag());
    
            // $meal->setCategory($this->categoryRepository->getRandomCategory());
    
            // $meal->setDescription($faker->paragraph());
    
            // $this->entityManager->persist($meal);



        }
        


        // dd($meal);

        $this->entityManager->flush();

        return $this->render('meals/create_data.html.twig', [
            // 'ingredient' => $ingredient
        ]);
    }


}

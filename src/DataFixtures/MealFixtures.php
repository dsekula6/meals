<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Tag;
use App\Entity\Meal;
use App\Entity\Category;
use App\Entity\Ingredient;
use App\Entity\TagTranslation;
use App\Entity\MealTranslation;
use App\Repository\TagRepository;
use App\Repository\MealRepository;
use App\Entity\CategoryTranslation;
use App\Entity\IngredientTranslation;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\IngredientRepository;
use DateTime;
use DoctrineExtensions\Query\Mysql\Date;
use Doctrine\Bundle\FixturesBundle\Fixture;

class MealFixtures extends Fixture
{
    private $ingredientRepository;
    private $tagRepository;
    private $categoryRepository;
    private $mealRepository;

    public function __construct(
        IngredientRepository $ingredientRepository,
        TagRepository $tagRepository,
        CategoryRepository $categoryRepository,
        MealRepository $mealRepository
    ) {
        $this->ingredientRepository = $ingredientRepository;
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
        $this->mealRepository = $mealRepository;
    }
    public function load(ObjectManager $manager): void
    {
        $ingredients = [];
        $tags = [];
        $categories = [];
        $meals = [];
        $brojSastojaka = 10;
        $brojJela = 50;

        $faker = Factory::create();
        for ($i = 1; $i < $brojSastojaka+1; $i++) { 
                   //ingredient random data

            $ingredient = new Ingredient();
            $ingredient->setTitle($faker->word());
            $ingredient->setSlug($faker->word());
            $ingredients[] = $ingredient;
            $manager->persist($ingredient);
        }
        // $manager->flush();
        for ($i = 1; $i < $brojSastojaka+1; $i++) { 
                   //tag random data

            $tag = new Tag();
            $tag->setTitle('TAG'.strval($i));
            $tag->setSlug('tag-'.strval($i));
            $tags[] = $tag;
            $manager->persist($tag);
        }
        // $manager->flush();
        for ($i = 1; $i < $brojSastojaka+1; $i++) { 
                   //category random data

            $category = new Category();
            $category->setTitle('CATEGORY'.strval($i));
            $category->setSlug('cat-'.strval($i));
            $categories[] = $category;
            $manager->persist($category);
        }
        // $manager->flush();
        for ($i = 1; $i < $brojSastojaka+1; $i++) { 
                   //tag translation random data

            $translation = new TagTranslation();
            $translation->setLocale('hr');
            $translation->setTag($tags[$i-1]);
            $translation->setTitle('HRVtag'.strval($i));
            $manager->persist($translation);
        }        
        // $manager->flush();
        for ($i = 1; $i < $brojSastojaka+1; $i++) { 
                   //category translation random data

            $translation = new CategoryTranslation();
            $translation->setLocale('hr');
            $translation->setCategory($categories[$i-1]);
            $translation->setTitle('KATEGORIJA'.strval($i));
            $manager->persist($translation);
        }
        // $manager->flush();
        for ($i = 1; $i < $brojSastojaka+1; $i++) { 
                   //ingredient translation random data

            $translation = new IngredientTranslation();
            $translation->setLocale('hr');
            $translation->setIngredient($ingredients[$i-1]);
            $translation->setTitle('HRV'.$ingredients[$i-1]->getTitle());
            $manager->persist($translation);
        }
        // $manager->flush();
        for ($i = 1; $i < $brojJela; $i++) {

                   // random meal data

            $meal = new Meal();
            $meal->setTitle($faker->words(2, true));
            
            $meal->addIngredient($ingredients[array_rand($ingredients)]);
            $meal->addIngredient($ingredients[array_rand($ingredients)]);
            $meal->addIngredient($ingredients[array_rand($ingredients)]);
            // $meal->addIngredient($this->ingredientRepository->getRandomIngredient());
            // $meal->addIngredient($this->ingredientRepository->getRandomIngredient());
    
            $meal->addTag($tags[array_rand($tags)]);
            $meal->addTag($tags[array_rand($tags)]);
            // $meal->addTag($this->tagRepository->getRandomTag());
    
            $meal->setCategory($categories[array_rand($categories)]);
    
            $meal->setDescription($faker->paragraph());
            
            if ($i>10 && $i<20) {
                $meal->setDeletedAt(new DateTime(date('Y-m-d', 1000000)));
            }
    
            $meals[] = $meal;

            $manager->persist($meal);
            // dd($meal);

        }
        // $manager->flush();
        for ($i = 1; $i < $brojJela; $i++) {
                //meal translation random data
            

            $translation = new MealTranslation();
            $translation->setLocale('hr');
            $translation->setMeal($meals[$i-1]);
            $translation->setTitle('HRV'.$translation->getMeal()->getTitle());
            $translation->setDescription('HRV'.$translation->getMeal()->getDescription());
            $manager->persist($translation);

            
        }
        $manager->flush();
    }
    
}

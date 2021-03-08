<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Job;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("category")
 */
class CategoryController extends AbstractController {
    /**
     * Lists all Category entities
     * @Route("/", name="category.list")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function list(EntityManagerInterface $em) : Response {
        $categories = $em->getRepository(Category::class)->findWithActiveJobs();
        return $this->render('category/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route ("/{id}", name ="category.show", requirements={"id":"\d+"})
     * @param Category $category
     * @return Response
     */

    public function show(Category $category) : Response {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route ("/activos", name="job.activated")
     * @return Response
     */
    public function showActivated() : Response {
        $jobs = $this->getDoctrine()->getRepository(Job::class)->findBy(
            ['activated' => 1]);

        return $this->render('job/list.html.twig', [
            'jobs' => $jobs,
        ]);
    }
}
?>
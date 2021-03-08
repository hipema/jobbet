<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Job;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

/**
 * @Route("job")
 */
class JobController extends AbstractController {
    /**
     * Lists all job entities
     * @Route("/", name="job.list")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function list(EntityManagerInterface $em) : Response {
        $categories = $em->getRepository(Category::class)->findWithActiveJobs();
        return $this->render('job/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Entity("job", expr="repository.findActiveJob(id)")
     * @Route ("/{id}", name ="job.show", requirements={"id":"\d+"})
     * @param Job $job
     * @return Response
     */

    public function show(Job $job) : Response {
        return $this->render('job/show.html.twig', [
            'job' => $job,
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
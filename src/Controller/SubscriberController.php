<?php
namespace App\Controller;

use App\Entity\Subscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SubscriberController extends AbstractController
{
    #[Route('/api/subscribers', methods: ['GET'])]
    public function getSubscribers(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $startTime = microtime(true);
        $criteria = array_filter($request->query->all());
        $repository = $entityManager->getRepository(Subscriber::class);
        $qb = $repository->createQueryBuilder('s');

        foreach ($criteria as $key => $value) {
            $qb->andWhere('s.' . $key . ' LIKE :'. $key)
                ->setParameter($key, '%' . $value . '%');
        }

        $subscribers = $qb->getQuery()->getResult();
        $executionTime = microtime(true) - $startTime;

        return $this->json([
            'execution_time' => $executionTime . ' seconds',
            'data' => $subscribers
        ]);
    }
}

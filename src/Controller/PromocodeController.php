<?php

namespace App\Controller;

use App\Entity\Promocode;
use App\Services\KeywordService;
use App\Validator\ComplexValidator;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PromocodeController extends AbstractController
{

    private EntityManager $entityManager;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->entityManager = $doctrine->getManager();
    }

    #[Route('/promocode', name: 'promocode')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Promocode',
        ]);
    }

    #[Route('/generate', name: 'generate', methods: ['GET'])]
    public function generate(Request $request): Response
    {

        $validator = new ComplexValidator();
        $validator->validate($request);

        if (!$validator->isPassed()) {
            return $this->json([
                'status' => 'error',
                'data' => [],
                'errors' => $validator->getErrors()
            ]);
        }

        $discountPercent = $request->get('discount_percent');
        $numberOfUses = $request->get('number_of_uses');
        $keyword = KeywordService::createNewKeyword();

        try {
            $promocode = new Promocode();
            $promocode->setDiscountPercent($discountPercent);
            $promocode->setNumberOfUses($numberOfUses);
            $promocode->setKeyword($keyword);
            $this->entityManager->persist($promocode);
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            return $this->json([
                'status' => 'error',
                'data' => [],
                'errors' => [$exception->getMessage()]
            ]);
        }
        return $this->json([
            'status' => 'success',
            'data' => $keyword,
            'errors' => []
        ]);
    }
}

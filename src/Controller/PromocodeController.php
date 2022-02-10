<?php

namespace App\Controller;

use App\Entity\Promocode;
use App\Repository\PromocodeRepository;
use App\Services\KeywordService;
use App\Validator\ComplexValidator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PromocodeController extends AbstractController
{

    private ObjectManager $entityManager;

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

        if (!$validator->validateGeneration($request)->isPassed()) {
            return $this->prepareResponse('error', errors: $validator->getErrors());
        }

        $keyword = KeywordService::createNewKeyword();
        try {
            $promocode = new Promocode();
            $promocode->setDiscountPercent($request->get('discount_percent'));
            $promocode->setNumberOfUses($numberOfUses = $request->get('number_of_uses'));
            $promocode->setKeyword($keyword);
            $this->entityManager->persist($promocode);
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            return $this->prepareResponse('error', errors: [$exception->getMessage()]);
        }
        return $this->prepareResponse('success', ['keyword' => $keyword]);
    }

    #[Route('/apply', name: 'apply', methods: ['GET'])]
    public function apply(Request $request): Response
    {
        $validator = new ComplexValidator();
        if (!$validator->validateApplication($request)->isPassed()) {
            return $this->prepareResponse('error', errors: $validator->getErrors());
        }


        /** @var Promocode $promocode */
        $promocode = ($this->entityManager->getRepository(Promocode::class))
            ->findOneBy(['keyword' => $request->get('keyword')]);
        if ($promocode === null) {
            return $this->prepareResponse('error', errors: ['Promocode does not exist!']);
        }
        if ($promocode->getNumberOfUses() === 0) {
            return $this->prepareResponse(
                'error',
                errors: ['The number of uses of the promocode has been exhausted!']
            );
        }

        $this->entityManager->beginTransaction();
        try {
            $promocode->setNumberOfUses($promocode->getNumberOfUses() - 1);
            $this->entityManager->persist($promocode);
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (\Throwable $exception) {
            $this->entityManager->rollback();
            return $this->prepareResponse('error', errors: [$exception->getMessage()]);
        }

        return $this->prepareResponse(
            'success',
            ['number_of_uses' => $promocode->getNumberOfUses(), 'discount_percent' => $promocode->getDiscountPercent()]
        );
    }

    private function prepareResponse(string $status, array $data = [], array $errors = []): Response
    {
        return $this->json(['status' => $status, 'data' => $data, 'errors' => $errors]);
    }
}

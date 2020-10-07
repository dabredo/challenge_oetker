<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\RecordEntity;
use App\Repository\RecordRepositoryInterface;

class DeleteRecordController extends AbstractController
{
    private RecordRepositoryInterface $recordRepository;

    public function __construct(
        RecordRepositoryInterface $recordRepository
    ) {
        $this->recordRepository = $recordRepository;
    }

    /**
     * Delete record for sale
     *
     * @Route("/records/{id}", methods={"DELETE"})
     * @SWG\Response(
     *     response=204,
     *     description="Record deleted",
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Not found",
     * )
     */
    public function run(string $id): JsonResponse
    {
        $record = $this->recordRepository->find($id);
        if (!$record) {
            throw $this->createNotFoundException();
        }

        $this->recordRepository->delete($record);

        return $this->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}

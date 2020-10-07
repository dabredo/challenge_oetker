<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RecordRepositoryInterface;

class SearchRecordController extends AbstractController
{
    private ValidatorInterface $validator;
    private RecordRepositoryInterface $recordRepository;

    public function __construct(
        ValidatorInterface $validator,
        RecordRepositoryInterface $recordRepository
    ) {
        $this->validator = $validator;
        $this->recordRepository = $recordRepository;
    }

    /**
     * Search records for sale
     *
     * @Route("/records", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="List of records",
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Bad request",
     * )
     * @SWG\Parameter(
     *     name="title",
     *     in="query",
     *     description="Field to search by title",
     *     type="string"
     * )
     * @SWG\Parameter(
     *     name="artist",
     *     in="query",
     *     description="Field to search by artist",
     *     type="string"
     * )
     */
    public function run(Request $request): JsonResponse
    {
        $title = $request->query->get('title');
        $artist = $request->query->get('artist');

        $result = $this->recordRepository->search($title, $artist);

        $response = [];
        foreach ($result as $r) {
            $response[] = [
                'id' => $r->getId(),
                'title' => $r->getTitle(),
                'artist' => $r->getArtist(),
                'description' => $r->getDescription(),
                'price' => $r->getPrice(),
                'releaseDate' => $r->getReleaseDate()->format('Y-m-d'),
            ];
        }

        return $this->json($response);
    }
}

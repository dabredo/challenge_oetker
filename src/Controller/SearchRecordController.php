<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\RecordRepository;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

class SearchRecordController extends AbstractController
{
    public function __construct(ValidatorInterface $validator, RecordRepository $recordRepository)
    {
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
     *     name="author",
     *     in="query",
     *     description="Field to search by author",
     *     type="string"
     * )
     */
    public function run(Request $request): JsonResponse
    {
        $title = $request->query->get('title');
        $author = $request->query->get('author');

        $result = $this->recordRepository->search($title, $author);

        $response = [];
        foreach ($result as $r) {
            $response[] = [
                'id' => $r->getId(),
                'title' => $r->getTitle(),
                'author' => $r->getAuthor(),
                'description' => $r->getDescription(),
                'price' => $r->getPrice(),
                'releaseDate' => $r->getReleaseDate()->format('Y-m-d'),
            ];
        }

        return $this->json($response);
    }
}

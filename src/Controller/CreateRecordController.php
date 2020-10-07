<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use App\DTO\RecordDTO;
use App\Entity\RecordEntity;
use App\Repository\RecordRepositoryInterface;

class CreateRecordController extends AbstractController
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
     * Create record for sale
     *
     * @Route("/records", methods={"POST"})
     * @SWG\Response(
     *     response=201,
     *     description="Record created",
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Bad request",
     * )
     * @SWG\Parameter(
     *     name="record",
     *     in="body",
     *     description="Record on sale",
     *     @SWG\Schema(
     *         @SWG\Property(property="title", type="string", example="The Four Seasons"),
     *         @SWG\Property(property="author", type="string", example="Vivaldi"),
     *         @SWG\Property(property="price", type="number", example=24.00),
     *         @SWG\Property(property="releaseDate", type="string", example="2017-05-19"),
     *         @SWG\Property(property="description", type="string", example="Anne-Sophie Mutter (violin)\nWiener Philharmoniker, Herbert von Karajan")
     *     )
     * )
     */
    public function run(Request $request): JsonResponse
    {
        $recordDTO = (new RecordDTO())
            ->setTitle($request->request->get('title'))
            ->setAuthor($request->request->get('author'))
            ->setReleaseDate($request->request->get('releaseDate'))
            ->setDescription($request->request->get('description'))
            ->setPrice($request->request->get('price'));


        $errors = $this->validator->validate($recordDTO);

        if ($errors->count() > 0) {
            $errorsResponse = [];

            foreach ($errors as $error) {
                $errorsResponse[] = [
                    'title' => $error->getPropertyPath(),
                    'message' => $error->getMessage(),
                ];
            }

            return $this->json(
                [ 'errors' => $errorsResponse ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $recordEntity = (new RecordEntity())
            ->setTitle($recordDTO->getTitle())
            ->setAuthor($recordDTO->getAuthor())
            ->setReleaseDate(new \DateTime($recordDTO->getReleaseDate()))
            ->setDescription($recordDTO->getDescription())
            ->setPrice($recordDTO->getPrice());

        $this->recordRepository->save($recordEntity);

        return $this->json(null, 201);
    }
}

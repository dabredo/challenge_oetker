<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use App\DTO\RecordRequestDTO;
use App\Entity\RecordEntity;
use App\Repository\RecordRepositoryInterface;

class CreateRecordController extends BaseController implements AuthenticationRequiredInterface
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
     * @SWG\Response(
     *     response=401,
     *     description="Unauthorized",
     * )
     * @SWG\Parameter(
     *     name="record",
     *     in="body",
     *     description="Record on sale",
     *     @SWG\Schema(
     *         @SWG\Property(property="title", type="string", example="The Four Seasons"),
     *         @SWG\Property(property="artist", type="string", example="Vivaldi"),
     *         @SWG\Property(property="price", type="number", example=24.00),
     *         @SWG\Property(property="releaseDate", type="string", example="2017-05-19"),
     *         @SWG\Property(property="description", type="string", example="Anne-Sophie Mutter (violin), Wiener Philharmoniker, Herbert von Karajan")
     *     )
     * )
     * @SWG\Parameter(
     *     name="api-key",
     *     in="header",
     *     description="Use the valid api-key 12345",
     *     type="string"
     * )
     */
    public function run(Request $request): JsonResponse
    {
        $recordRequest = (new RecordRequestDTO())
            ->setTitle($request->request->get('title'))
            ->setArtist($request->request->get('artist'))
            ->setReleaseDate($request->request->get('releaseDate'))
            ->setDescription($request->request->get('description'))
            ->setPrice($request->request->get('price'));

        $errors = $this->validator->validate($recordRequest);
        if ($errors->count() > 0) {
            return $this->createErrorsResponse($errors);
        }

        $record = (new RecordEntity())
            ->setTitle($recordRequest->getTitle())
            ->setArtist($recordRequest->getArtist())
            ->setReleaseDate(new \DateTime($recordRequest->getReleaseDate()))
            ->setDescription($recordRequest->getDescription())
            ->setPrice($recordRequest->getPrice());

        $this->recordRepository->save($record);

        return $this->json(null, JsonResponse::HTTP_CREATED);
    }
}

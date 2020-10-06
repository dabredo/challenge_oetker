<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Imbo\BehatApiExtension\Context\ApiContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Doctrine\ORM\EntityManager;
use Behat\Gherkin\Node\TableNode;
use App\Entity\RecordEntity;
use App\Repository\RecordRepository;

final class ShopContext extends ApiContext implements Context
{
    private KernelInterface $kernel;
    private EntityManager $em;
    private RecordRepository $recordRepository;

    public function __construct(
        KernelInterface $kernel,
        EntityManager $em,
        RecordRepository $recordRepository
    ) {
        $this->kernel = $kernel;
        $this->em = $em;
        $this->recordRepository = $recordRepository;

    }

    /** @BeforeScenario */
    public function clearDB()
    {
        $connection = $this->em->getConnection();
        $platform   = $connection->getDatabasePlatform();
        $connection->executeUpdate($platform->getTruncateTableSQL('records', true));
    }

    /**
     * @Given the following records exist:
     */
    public function theFollowingRecordsExist(TableNode $table)
    {
        foreach ($table as $row) {
            $recordEntity = (new RecordEntity())
                ->setTitle($row['title'])
                ->setAuthor($row['author'])
                ->setReleaseDate(new \DateTime($row['releaseDate']))
                ->setPrice((float) $row['price'])
                ->setDescription($row['description']);

            $this->recordRepository->save($recordEntity);
        }
    }
}

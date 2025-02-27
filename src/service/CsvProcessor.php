<?php
namespace App\service;

use App\Entity\Subscriber;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;

class CsvProcessor
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function processCsv(string $filePath): void
    {
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $batchSize = 500;
        $i = 0;

        $this->entityManager->beginTransaction();

        try {
            foreach ($csv as $record) {
                $subscriber = new Subscriber();
                $subscriber->setNombre($record['nombre']);
                $subscriber->setEmail($record['email']);
                $subscriber->setAge((int) $record['age']);
                $subscriber->setAddress($record['address']);

                $this->entityManager->persist($subscriber);
                $i++;

                if ($i % $batchSize === 0) {
                    $this->entityManager->flush();
                    $this->entityManager->clear();
                }
            }

            $this->entityManager->flush();
            $this->entityManager->clear();
            $this->entityManager->commit();
        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }
}

<?php

namespace App\Syllabus\Service;

use Symfony\Component\HttpFoundation\StreamedResponse;

abstract class AbstractExportService
{
    abstract public function getHeaders(): array;

    abstract public function getEntityFields($entity): array;

    public function export(string $fileName, array $entities)
    {
        $fileName = $fileName.".csv";
        $fileName = preg_replace('/\s+/', '_', $fileName);
        $response = new StreamedResponse();

        $response->setCallback(function () use ($entities) {
            $handle = fopen('php://output', 'w+');

            fputcsv($handle, array_map('utf8_decode', $this->getHeaders()), ';');

            foreach ($entities as $entity)
            {
                fputcsv($handle, array_map('utf8_decode', $this->getEntityFields($entity)), ';');
            }

            fclose($handle);
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv; charset=utf-8', 'application/force-download');
        $response->headers->set('Content-Disposition','attachment; filename='.$fileName);
        return ($response);
    }
}
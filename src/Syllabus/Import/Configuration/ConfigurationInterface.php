<?php


namespace App\Syllabus\Import\Configuration;


use App\Syllabus\Import\Extractor\ExtractorInterface;
use App\Syllabus\Import\Matching\MatchingInterface;
use App\Syllabus\Import\Transformer\TransformerInterface;

interface ConfigurationInterface
{
    public function getExtractor(): ExtractorInterface;

    public function getTransformer(): TransformerInterface;

    public function getMatching(): MatchingInterface;
}
<?php


namespace AppBundle\Parser;


interface ParserInterface
{
    public function parse(string $source, array $options = []): array;

}
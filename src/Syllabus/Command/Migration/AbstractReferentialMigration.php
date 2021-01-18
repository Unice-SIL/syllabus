<?php


namespace App\Syllabus\Command\Migration;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class AbstractReferentialMigration
 * @package AppBundle\Command\Migration
 */
abstract class AbstractReferentialMigration extends Command
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * CampusMigration constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    /***
     * @return string
     */
    abstract protected function getEntityClassName(): string;

    /**
     * @return array list of entities to create if not already exists
     */
    abstract protected function getEntities(): array;

    /**
     * @return string|null
     */
    abstract protected function getStartMessage(): string;

    /**
     * @return string|null
     */
    abstract protected function getEndMessage(): string;

    /**
     * @return array
     */
    protected function getFindByFields(): array
    {
        return ['code'];
    }

    /**
     * @return int
     */
    protected function getBatchSize(): int {
        return 5;
    }

    /**
     * @param SymfonyStyle $io
     */
    protected function preExecute(SymfonyStyle $io)
    {
    }

    /**
     * @param SymfonyStyle $io
     */
    protected function postExecute(SymfonyStyle $io)
    {
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->preExecute($io);

        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $io->title($this->getStartMessage());

        $entities = $this->getEntities();

        $io->progressStart(count($entities));

        $i = 0;
        foreach ($entities as $entity)
        {
            $findByFields = $this->getFindByFields();
            $findBy = [];
            foreach ($findByFields as $field)
            {
                $findBy[$field] = $propertyAccessor->getValue($entity, $field);
            }

            $e = $this->em->getRepository($this->getEntityClassName())->findBy($findBy);
            if(count($e) === 0)
            {
                $this->em->persist($entity);
                if(($i % $this->getBatchSize()) === 0)
                {
                    $this->em->flush();
                    $this->em->clear($this->getEntityClassName());
                }
                $i++;
            }
            $io->progressAdvance();
        }
        $this->em->flush();
        $io->progressFinish();

        $io->title($this->getEndMessage());

        $this->postExecute($io);

        $this->em->clear();

    }

}
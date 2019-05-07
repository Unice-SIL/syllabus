<?php

namespace AppBundle\Importer\Common;


use AppBundle\Repository\YearRepositoryInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractImporterCommand extends Command
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var OutputInterface
     */
    protected $logout;

    /**
     * @var string
     */
    protected $importerServiceName;

    /**
     * @var
     */
    protected $importerService;

    /**
     * @var array
     */
    protected $importerServiceArgs;

    /**
     * @var YearRepositoryInterface
     */
    protected $yearRepository;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * AbstractImporterCommand constructor.
     * @param ContainerInterface $container
     * @param YearRepositoryInterface $yearRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        ContainerInterface $container,
        YearRepositoryInterface $yearRepository,
        LoggerInterface $logger
    )
    {
        $this->container = $container;
        $this->yearRepository = $yearRepository;
        $this->logger = $logger;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->addArgument('parameters', InputArgument::IS_ARRAY, 'Importer service parameters (optionnal)');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $output->writeln("==============================");
        $output->writeln("Start importer");
        $output->writeln(date('d/m/Y h:i:s', time()));
        $output->writeln($this->getDescription());
        $output->writeln("==============================");

        try{
            // Get importer service
            $this->importerServiceName = $input->getArgument('service');
            $output->writeln(sprintf("Get service %s", $this->importerServiceName));
            $this->importerService = $this->container->get($this->importerServiceName);
            $this->importerServiceArgs = $this->handleParameters($input->getArgument('parameters'));
            $this->start();
        }catch (\Exception $e){
            $this->logger->error((string)$e);
            $this->output->writeln($e->getMessage());
        }

        $output->writeln("==============================");
        $output->writeln(date('d/m/Y h:i:s', time()));
        $output->writeln("End importer");
        $output->writeln("==============================");

    }

    /**
     * @param array $parameters
     * @return array
     */
    protected function handleParameters(array $parameters=[]){
        $params = [];
        foreach ($parameters as $parameter){
            $res = preg_match('/^(.*)=(.*)$/', $parameter, $matches);
            if($res==1){
                if(!empty($matches[1])) {
                    $params[$matches[1]] = $matches[2];
                    continue;
                }
            }
            $params[] = $parameter;
        }
        return $params;
    }

    /**
     * @return array
     */
    protected function getYearsToImport(): array
    {
        $years = $this->yearRepository->findToImport();
        return array_map(function($a){
            return $a->getId();
        }, $years);
    }

    /**
     * @return mixed
     */
    abstract protected function start();

}
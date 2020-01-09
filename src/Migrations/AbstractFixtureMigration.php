<?php
/**
 * Created by PhpStorm.
 * User: Fred
 * Date: 09/01/2020
 * Time: 15:50
 */

namespace DoctrineMigrations;


use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AbstractFixtureMigration extends AbstractMigration implements ContainerAwareInterface
{

    /**
     * @var ContainerInterface|null
     */
    private $container;

    public function up(Schema $schema): void
    {
        // TODO: Implement up() method.
    }

    public function down(Schema $schema): void
    {
        // TODO: Implement down() method.
    }

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param array $fixtures
     * @param bool $append
     */
    public function loadFixtures(array $fixtures, $append = true)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $loader = new ContainerAwareLoader($this->container);
        array_map([$loader, 'addFixture'], $fixtures);
        $purger = null;
        if ($append === false) {
            $purger = new ORMPurger($em);
            $purger->setPurgeMode(ORMPurger::PURGE_MODE_DELETE);
        }
        $executor = new ORMExecutor($em, $purger);
        $output = new ConsoleOutput();
        $executor->setLogger(function($message) use ($output) {
            $output->writeln(sprintf('  <comment>></comment> <info>%s</info>', $message));
        });
        $executor->execute($loader->getFixtures(), $append);
    }
}
<?php


namespace AppBundle\Fixture;


use AppBundle\Entity\BakActivity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BakActivityFixture extends Fixture
{

    const BAK_ACTIVITY_1 = '018ae167-bc6b-4c68-b0e2-08a0a6c06459';
    const BAK_ACTIVITY_2 = '1e46eb19-e63b-4e3c-b329-06694db99feb';
    const BAK_ACTIVITY_3 = '04cac0bb-2866-40db-b4ee-7a795cff9e84';
    const BAK_ACTIVITY_4 = '42259f31-1b15-4258-b968-22be434afd70';

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $activity = new BakActivity();
        $activity->setId(self::BAK_ACTIVITY_1)
            ->setLabel('Séance question / réponse')
            ->setLabelVisibility(true)
            ->setType('activity')
            ->setMode('class')
            ->setGrp('groups')
            ->setObsolete(false)
            ->setOrd(4);
        $this->addReference(self::BAK_ACTIVITY_1, $activity);
        $manager->persist($activity);

        $activity = new BakActivity();
        $activity->setId(self::BAK_ACTIVITY_2)
            ->setLabel('Exercices')
            ->setLabelVisibility(true)
            ->setType('activity')
            ->setMode('autonomy')
            ->setGrp('individual')
            ->setObsolete(false)
            ->setOrd(5);
        $this->addReference(self::BAK_ACTIVITY_2, $activity);
        $manager->persist($activity);

        $activity = new BakActivity();
        $activity->setId(self::BAK_ACTIVITY_3)
            ->setLabel('Production multimédia (vidéo, affiche, poster, blog, wiki, prototype, portfolio…)')
            ->setLabelVisibility(true)
            ->setType('evaluation')
            ->setMode('cc')
            ->setObsolete(false)
            ->setOrd(6);
        $this->addReference(self::BAK_ACTIVITY_3, $activity);
        $manager->persist($activity);

        $activity = new BakActivity();
        $activity->setId(self::BAK_ACTIVITY_4)
            ->setLabel('Production artistique (installation, sculpture, performance…))')
            ->setLabelVisibility(true)
            ->setType('evaluation')
            ->setMode('ct')
            ->setObsolete(false)
            ->setOrd(7);
        $this->addReference(self::BAK_ACTIVITY_4, $activity);
        $manager->persist($activity);

        $manager->flush();
    }
}
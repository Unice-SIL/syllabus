<?php

namespace AppBundle\Fixture;

use AppBundle\Entity\Activity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

/**
 * Class ActivityFixture
 * @package AppBundle\Fixture
 */
class ActivityFixture extends Fixture implements FixtureGroupInterface
{
    /**
     *
     */
    const ACTIVITY_1 = 'activity1';
    const ACTIVITY_2 = 'activity2';
    const ACTIVITY_3 = 'activity3';
    const ACTIVITY_4 = 'activity4';
    const ACTIVITY_5 = 'activity5';
    const ACTIVITY_6 = 'activity6';
    const ACTIVITY_7 = 'activity7';


    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        /**
         * ACTIVITIES IN CLASS HEAD
         */

        // Cours Magistral
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Cours Magistral")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $this->addReference(self::ACTIVITY_1, $activity);
        $manager->persist($activity);


        /**
         * ACTIVITIES IN CLASS TOGETHER
         */

        // Débat
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Débat")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Démonstration
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Démonstration ")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Discussion / Réflexion
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Discussion / réflexion")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Étude d'un document (texte, vidéo, cours en ligne…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Étude d'un document (texte, vidéo…)")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $this->addReference(self::ACTIVITY_2, $activity);
        $manager->persist($activity);

        // Étude de cas
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Étude de cas")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Exercices
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Exercices")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Jeu de rôle
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Jeu de rôle")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Jeu sérieux
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Jeu sérieux")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production artistique (installation, sculpture, performance…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production artistique (installation, sculpture, performance…)")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production écrite (synthèse / compte rendu, carte mentale…) 
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production écrite (synthèse / compte rendu, carte mentale…)")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production multimédia (vidéo, affiche, poster, blog, wiki, prototype, portfolio…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production multimédia (vidéo, affiche, poster, blog, wiki, prototype, portfolio…)")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production orale (entretien, argumentaire, exposé, narration…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production orale (entretien, argumentaire, exposé, narration…)")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Projet
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Projet")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Tournoi
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Tournoi")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Séance question / réponse
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Séance question / réponse")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Vote interactif
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Vote interactif (Quizlet, Socrative, Mentimeter)")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Exercice d'évaluation par les pairs
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Exercice d'évaluation par les pairs")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Mise en situation
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Mise en situation")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Recherche documentaire
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Recherche documentaire")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);


        /**
         * ACTIVITIES IN CLASS IN GROUPS
         */

        // Débat
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Débat")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Démonstration
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Démonstration")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Discussion / Réflexion
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Discussion / réflexion")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $this->addReference(self::ACTIVITY_3, $activity);
        $manager->persist($activity);

        // Étude d'un document (texte, vidéo…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Étude d'un document (texte, vidéo…)")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Étude de cas
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Étude de cas")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Exercices
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Exercices")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Exercice d'évaluation par les pairs
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Exercice d'évaluation par les pairs")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Exercices pratiques (observation, expérimentation, simulation…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Exercices pratiques (observation, expérimentation, simulation…)")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Mise en situation
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Mise en situation")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Projet
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Projet")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production écrite (synthèse / compte rendu, carte mentale…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production écrite (synthèse / compte rendu, carte mentale…)")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production orale (entretien, argumentaire, exposé, narration…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production orale (entretien, argumentaire, exposé, narration…)")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production multimédia (vidéo, affiche, poster, blog, wiki, prototype, portfolio…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production multimédia (vidéo, affiche, poster, blog, wiki, prototype, portfolio…)")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production artistique (installation, sculpture, performance…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production artistique (installation, sculpture, performance…)")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Recherche documentaire
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Recherche documentaire")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Séance question / réponse
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Séance question / réponse")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Vote interactif
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Vote interactif (Quizlet, Socrative, Mentimeter)")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Jeu de rôle
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Jeu de rôle")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Jeu sérieux
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Jeu sérieux")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);


        /**
         * ACTIVITIES IN AUTONOMY HEAD
         */

        // Cours en ligne
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Cours en ligne")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $this->addReference(self::ACTIVITY_4, $activity);
        $manager->persist($activity);


        /**
         * ACTIVITIES IN AUTONOMY COLLECTIVE
         */

        // Étude d'un document (texte, vidéo, cours en ligne…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Étude d'un document (texte, vidéo, cours en ligne…)")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $this->addReference(self::ACTIVITY_5, $activity);
        $manager->persist($activity);

        // Étude de cas
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Étude de cas")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Exercice d'évaluation par les pairs
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Exercice d'évaluation par les pairs")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Exercices
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Exercices")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production artistique (installation, sculpture, performance…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production artistique (installation, sculpture, performance…)")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production écrite (dissertation, synthèse / compte rendu…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production écrite (dissertation, synthèse / compte rendu…)")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production multimédia (vidéo, affiche, poster, blog, wiki, prototype, portfolio…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production multimédia (vidéo, affiche, poster, blog, wiki, prototype, portfolio…)")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production orale (entretien, argumentaire, exposé, narration…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production orale (entretien, argumentaire, exposé, narration…)")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Projet
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Projet")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Recherche documentaire
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Recherche documentaire")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Tournoi
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Tournoi")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Jeu sérieux
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Jeu sérieux")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);



        /**
         * ACTIVITIES IN AUTONOMY INDIVIDUAL
         */

        // Étude d'un document (texte, vidéo, cours en ligne…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Étude d'un document (texte, vidéo, cours en ligne…)")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Étude de cas
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Étude de cas")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Exercice d'évaluation par les pairs
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Exercice d'évaluation par les pairs")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Exercices
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Exercices")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Projet
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Projet")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Recherche documentaire
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Recherche documentaire")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Participation au forum de discussion
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Participation au forum de discussion")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production artistique (installation, sculpture, performance…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production artistique (installation, sculpture, performance…)")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production écrite (dissertation, synthèse / compte rendu…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production écrite (dissertation, synthèse / compte rendu…)")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production multimédia (vidéo, affiche, poster, blog, wiki, prototype, portfolio…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production multimédia (vidéo, affiche, poster, blog, wiki, prototype, portfolio…)")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production orale (entretien, argumentaire, exposé, narration…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production orale (entretien, argumentaire, exposé, narration…)")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Test d'auto-évaluation
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Test d'auto-évaluation")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $this->addReference(self::ACTIVITY_6, $activity);
        $manager->persist($activity);

        // Jeu sérieux
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Jeu sérieux")
            ->setLabelVisibility(true)
            
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);


        /**
         * EVALUATION CC
         */

        // Evalué plus tard
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Evalué plus tard")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Contribution au forum
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Contribution au forum")
            ->setLabelVisibility(true)
            
            
            ->setPosition(1)
            ->setObsolete(false);
        $manager->persist($activity);

        // Mise en situation
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Mise en situation")
            ->setLabelVisibility(true)
            
            
            ->setPosition(1)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production artistique (installation, sculpture, performance…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production artistique (installation, sculpture, performance…)")
            ->setLabelVisibility(true)
            
            
            ->setPosition(1)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production écrite (dissertation, commentaire de texte…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production écrite (dissertation, commentaire de texte…)")
            ->setLabelVisibility(true)
            
            
            ->setPosition(1)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production multimédia (vidéo, affiche, poster, blog, wiki, prototype, portfolio…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production multimédia (vidéo, affiche, poster, blog, wiki, prototype, portfolio…)")
            ->setLabelVisibility(true)
            
            
            ->setPosition(1)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production orale (entretien, exposé, discours d'éloquence, grand oral…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production orale (entretien, exposé, discours d'éloquence, grand oral…)")
            ->setLabelVisibility(true)
            
            
            ->setPosition(1)
            ->setObsolete(false);
        $manager->persist($activity);

        // Test standardisé (Moodle, QCM, WIMS…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Test standardisé (Moodle, QCM, WIMS…)")
            ->setLabelVisibility(true)
            
            
            ->setPosition(1)
            ->setObsolete(false);
        $manager->persist($activity);

        // Tournoi
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Tournoi")
            ->setLabelVisibility(true)
            
            
            ->setPosition(1)
            ->setObsolete(false);
        $manager->persist($activity);

        // Exercice pratique
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Exercice pratique")
            ->setLabelVisibility(true)
            
            
            ->setPosition(1)
            ->setObsolete(false);
        $manager->persist($activity);


        /**
         *  EVALUATION CT
         */

        // Pas d'évaluation terminale (sauf dispensés de CC*)
        /*
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Pas d'évaluation terminale (sauf dispensés de CC*)")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);
        */

        // Mise en situation
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Mise en situation")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $this->addReference(self::ACTIVITY_7, $activity);
        $manager->persist($activity);

        // Production artistique (installation, sculpture, performance…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production artistique (installation, sculpture, performance…)")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production écrite (dissertation, commentaire de texte…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production écrite (dissertation, commentaire de texte…)")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production multimédia (vidéo, affiche, poster, blog, wiki, prototype, portfolio…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production multimédia (vidéo, affiche, poster, blog, wiki, prototype, portfolio…)")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Production orale (entretien, exposé, discours d'éloquence, grand oral…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Production orale (entretien, exposé, discours d'éloquence, grand oral…)")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);

        // Test standardisé (Moodle, QCM, WIMS…)
        $activity = new Activity();
        $activity->setId(Uuid::uuid4())
            ->setLabel("Test standardisé (Moodle, QCM, WIMS…)")
            ->setLabelVisibility(true)
            
            
            ->setPosition(0)
            ->setObsolete(false);
        $manager->persist($activity);


        //
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['prod', 'test'];
    }
}
<?php


namespace AppBundle\Command\Migration;


use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\Language;
use Gedmo\Translatable\Entity\Translation;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class LanguageMigration
 * @package AppBundle\Command\Migration
 */
class LanguageMigration extends AbstractReferentialMigration
{

    protected static $defaultName = 'app:language-migration';

    /**
     * @return string
     */
    protected function getStartMessage(): string
    {
        return 'Start of languages creation';
    }

    /**
     * @return string
     */
    protected function getEndMessage(): string
    {
        return 'End of languages creation';
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return Language::class;
    }

    /**
     * @return array
     */
    protected function getEntities(): array
    {
        $repo = $this->em->getRepository(Translation::class);

        $languages = [];

        // DE
        $language = new Language();
        $language->setCode('DE')
            ->setLabel('Allemand');
        $repo->translate($language, 'label', 'en', 'Deutsch');
        $languages[] = $language;

        // EL
        $language = new Language();
        $language->setCode('EL')
            ->setLabel('Grec');
        $repo->translate($language, 'label', 'en', 'Greek');
        $languages[] = $language;

        // EN
        $language = new Language();
        $language->setCode('EN')
            ->setLabel('Anglais');
        $repo->translate($language, 'label', 'en', 'English');
        $languages[] = $language;

        // ES
        $language = new Language();
        $language->setCode('ES')
            ->setLabel('Espagnol');
        $repo->translate($language, 'label', 'en', 'Spanish');
        $languages[] = $language;

        // FR
        $language = new Language();
        $language->setCode('FR')
            ->setLabel('Français');
        $repo->translate($language, 'label', 'en', 'French');
        $languages[] = $language;

        // IT
        $language = new Language();
        $language->setCode('IT')
            ->setLabel('Italien');
        $repo->translate($language, 'label', 'en', 'Italian');
        $languages[] = $language;

        // PT
        $language = new Language();
        $language->setCode('PT')
            ->setLabel('Portugais');
        $repo->translate($language, 'label', 'en', 'Portuguese');
        $languages[] = $language;

        // RU
        $language = new Language();
        $language->setCode('RU')
            ->setLabel('Russe');
        $repo->translate($language, 'label', 'ru', 'Russian');
        $languages[] = $language;

        // ZH
        $language = new Language();
        $language->setCode('ZH')
            ->setLabel('Chinois');
        $repo->translate($language, 'label', 'en', 'Chinese');
        $languages[] = $language;


        return $languages;
    }


    protected function postExecute(SymfonyStyle $io)
    {
        $io->title("Convert old languages field values to new format");

        $qb = $this->em->createQueryBuilder();
        $courseInfos = $qb->select('ci')
            ->from('AppBundle:CourseInfo', 'ci')
            ->where($qb->expr()->isNotNull('ci.bakLanguages'))
            ->getQuery()->getResult();

        $languages = $this->em->getRepository(Language::class)->findAll();

        $io->progressStart(count($courseInfos));

        $i = 0;
        /** @var CourseInfo $courseInfo */
        foreach ($courseInfos as $key => $courseInfo)
        {
            $change = false;
            /** @var Language $language */
            foreach ($languages as $language) {
                $method = "check{$language->getCode()}";
                if(method_exists($this, $method))
                {
                    if($this->$method($courseInfo->getBakLanguages()))
                    {
                        $courseInfo->addLanguage($language);
                        $change = true;
                    }
                }
            }
            if($change) $i++;
            if(($i % 20) === 0)
            {
                $this->em->flush();
            }

            unset($courseInfos[$key]);
        }
        $this->em->flush();

        $io->progressFinish();
    }

    /**
     * @param $string
     * @return bool
     */
    private function checkDE($string)
    {
        return $this->checkLang($string, "/allemand|deutsch/i");
    }

    /**
     * @param $string
     * @return bool
     */
    private function checkEL($string)
    {
        return $this->checkLang($string, "/grec|greek/i");
    }

    /**
     * @param $string
     * @return bool
     */
    private function checkEN($string)
    {
        return $this->checkLang($string, "/anglais|english|\ben\b/i");
    }

    /**
     * @param $string
     * @return bool
     */
    private function checkES($string)
    {
        return $this->checkLang($string, "/espagnol|spain/i");
    }

    /**
     * @param $string
     * @return bool
     */
    private function checkFR($string)
    {
        return $this->checkLang($string, "/français|francais|french|\bfr\b/i");
    }

    /**
     * @param $string
     * @return bool
     */
    private function checkIT($string)
    {
        return $this->checkLang($string, "/italien|italian/i");
    }

    /**
     * @param $string
     * @return bool
     */
    private function checkPT($string)
    {
        return $this->checkLang($string, "/portugais|portuguese/i");
    }

    /**
     * @param $string
     * @return bool
     */
    private function checkRU($string)
    {
        return $this->checkLang($string, "/russe|russian/i");
    }

    /**
     * @param $string
     * @return bool
     */
    private function checkZH($string)
    {
        return $this->checkLang($string, "/chinois|chinese/i");
    }

    /**
     * @param $string
     * @param $pattern
     * @return bool
     */
    private function checkLang($string, $pattern)
    {
        if(preg_match($pattern, $string, $matches) === 1)
        {
            return true;
        }
        return false;
    }

}
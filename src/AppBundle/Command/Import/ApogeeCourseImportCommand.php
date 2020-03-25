<?php


namespace AppBundle\Command\Import;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ApogeeCourseImportCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /**
         * Import courses
         *
         * SQL
         * select elp.* from element_pedagogi elp
         *  where elp.cod_elp not in (select ere.cod_elp_pere from elp_regroupe_elp ere where ere.cod_elp_pere = elp.cod_elp)
         *  and elp.eta_elp = 'O'
         *  and elp.tem_sus_elp = 'N'
         *  and elp.cod_nel in ('UE', 'ECUE')
         *  and elp.cod_elp='SLEPB111';
         *
         * MAPPING
         * cod_elp => course->code
         * cod_cmp => course_info->structure->code
         * cod_nel => course->type
         * lib_elp => course->title && course_info->title
         * nbr_crd_elp => course_info->ects
         */

        $course1 = [
            'cod_elp' => 'CODELP1',
            'cod_cmp' => 'SCI',
            'cod_nel' => 'ECUE',
            'lib_elp' => 'Course import 1',
            'nbr_crd_elp' => null
        ];
        $courses = [$course1];


        /**
         * Import parents courses
         *
         * SQL
         * select elp.* from element_pedagogi elp
         *  inner join elp_regroupe_elp ere on (ere.cod_elp_pere = elp.cod_elp)
         *  where ere.cod_elp_fils = $codElpFils
         *  and ere.eta_elp_fils = 'O' and ere.eta_elp_pere = 'O'
         *  and ere.tem_sus_elp_fils = 'N' and ere.tem_sus_elp_pere = 'N'
         *  and elp.eta_elp = 'O' and elp.tem_sus_elp = 'N'
         *  and elp.cod_nel in ('UE', 'ECUE');
         *
         * MAPPING
         * cod_elp => course->code
         * cod_cmp => course_info->structure->code
         * cod_nel => course->type
         * lib_elp => course->title && course_info->title
         * nbr_crd_elp => course_info->ects
         */
        $parent1 = [
            'cod_elp' => 'CODELP1',
            'cod_cmp' => 'SCI',
            'cod_nel' => 'ECUE',
            'lib_elp' => 'Course import 1',
            'nbr_crd_elp' => null
        ];
        /**
         * Add children code as key to retrieves the parents for test
         */
        $parents = [
             $course1['cod_elp'] => [$parent1]
        ];


        /**
         * Import teaching hours for syllabus
         *
         * SQL
         * select * from elp_chg_typ_heu ecth
         *  where ecth.cod_elp = $code
         *  and cod_anu = $year;
         *
         * MAPPING
         * nbr_heu_elp => course_info->teachingCmClass | course_info->teachingTdClass | course_info->teachingTpClass
         */
        $hour1 = [
            [
                'cod_typ_heu' => 'CM',
                'nbr_heu_elp' => 4
            ],
            [
                'cod_typ_heu' => 'TD',
                'nbr_heu_elp' => 6
            ],
            [
                'cod_typ_heu' => 'TP',
                'nbr_heu_elp' => 8
            ]
        ];
        /**
         * Add course code as key to retrieves the teaching hours for test
         */
        $hours = [
            $course1['cod_elp'] => $hour1
        ];




    }
}
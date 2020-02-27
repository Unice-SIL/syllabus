<?php


namespace AppBundle\Controller;


use AppBundle\Entity\CourseInfoField;
use AppBundle\Form\CourseInfo\ImportType;
use AppBundle\Helper\Report\ReportingHelper;
use AppBundle\Manager\CourseInfoManager;
use AppBundle\Manager\CoursePermissionManager;
use AppBundle\Parser\CourseInfoCsvParser;
use AppBundle\Parser\CoursePermissionCsvParser;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ImportController
 * @package AppBundle\Controller
 * @Route("/admin/import/csv", name="app_admin_import_csv_")
 */
class ImportController extends AbstractController
{

    /**
     * @Route("/course-info", name="course_info", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param CourseInfoManager $courseInfoManager
     * @param CourseInfoCsvParser $courseInfoCsvParser
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function courseInfo(Request $request, EntityManagerInterface $em, CourseInfoManager $courseInfoManager, CourseInfoCsvParser $courseInfoCsvParser)
    {
        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);

        $courseInfoFields = $em->getRepository(CourseInfoField::class)->findByImport(true);
        $fieldsToUpdate = array_map(function ($courseInfoField) {
            return $courseInfoField->getField();
        }, $courseInfoFields);

        /*
        $courseInfoFieldsAllowed = array_filter(iterator_to_array($courseInfoCsvParser->getCompleteMatching()), function ($value, $key) use ($fieldsToUpdate){
            return in_array($key, $fieldsToUpdate) || (is_array($value) && array_key_exists('required', $value) && $value['required'] === true);
        }, ARRAY_FILTER_USE_BOTH);
        */
        $courseInfoFieldsAllowed = iterator_to_array($courseInfoCsvParser->getCompleteMatching());


        if ($form->isSubmitted() and $form->isValid())
        {

            $courseInfos = $courseInfoCsvParser->parse($form->getData()['file']->getPathName(), [
                'allow_extra_field' => true,
                'allow_less_field' => true,
                'report' => ReportingHelper::createReport('Parsing du Fichier Csv'),
            ]);


            $fieldsToUpdate = array_intersect($fieldsToUpdate, $courseInfoCsvParser->getCsv()->getHeader());
            if(in_array('mccCtCoeffSession1', $fieldsToUpdate))
            {
                $fieldsToUpdate[] = 'mccCcCoeffSession1';
            }

            $validationReport = ReportingHelper::createReport('Insertion en base de données');

            foreach ($courseInfos as $lineIdReport => $courseInfo) {

                $validationReport = $courseInfoManager->updateIfExistsOrCreate($courseInfo, $fieldsToUpdate, [
                    'flush' => true,
                    'find_by_parameters' => [
                        'course' => $courseInfo->getCourse(),
                        'year' => $courseInfo->getYear(),
                    ],
                    'lineIdReport' => $lineIdReport,
                    'report' => $validationReport,
                ]);


            }

            $validationReport->finishReport(count($courseInfos));
            $request->getSession()->set('parsingCsvReport', $courseInfoCsvParser->getReport());
            $request->getSession()->set('validationReport', $validationReport);
            return $this->redirectToRoute('app_admin_import_csv_course_info');

        }

        return $this->render('import/course_info.html.twig', [
            'form' => $form->createView(),
            'parsingCsvReport' => $request->getSession()->remove('parsingCsvReport'),
            'validationReport' => $request->getSession()->remove('validationReport'),
            'courseInfoFieldsAllowed' => $courseInfoFieldsAllowed
        ]);
    }


    /**
     * @Route("/permission", name="permission", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param CoursePermissionManager $coursePermissionManager
     * @param CoursePermissionCsvParser $coursePermissionCsvParser
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function permission(Request $request, EntityManagerInterface $em, CoursePermissionManager $coursePermissionManager, CoursePermissionCsvParser $coursePermissionCsvParser)
    {

        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);

        $fieldsToUpdate = iterator_to_array($coursePermissionCsvParser->getCompleteMatching());
        $courseInfoFieldsAllowed = $fieldsToUpdate;

        if ($form->isSubmitted() and $form->isValid()) {

            $coursePermissions = $coursePermissionCsvParser->parse($form->getData()['file']->getPathName(), [
                'allow_extra_field' => false,
                'allow_less_field' => false,
                'report' => ReportingHelper::createReport('Parsing du Fichier Csv'),
            ]);

            $validationReport = ReportingHelper::createReport('Insertion en base de données');

            foreach ($coursePermissions as $lineIdReport => $coursePermission) {

                $validationReport = $coursePermissionManager->updateIfExistsOrCreate($coursePermission, ['permission'], [
                    'flush' => true,
                    'find_by_parameters' => [
                        'user' => $coursePermission->getUser(),
                        'courseInfo' => $coursePermission->getCourseInfo(),
                        'permission' => $coursePermission->getPermission()
                    ],
                    'lineIdReport' => $lineIdReport,
                    'report' => $validationReport
                ]);
            }

            $validationReport->finishReport(count($coursePermissions));
            $request->getSession()->set('parsingCsvReport', $coursePermissionCsvParser->getReport());
            $request->getSession()->set('validationReport', $validationReport);
            return $this->redirectToRoute('app_admin_import_csv_permission');

        }

        return $this->render('import/permission.html.twig', [
            'form' => $form->createView(),
            'parsingCsvReport' => $request->getSession()->remove('parsingCsvReport'),
            'validationReport' => $request->getSession()->remove('validationReport'),
            'courseInfoFieldsAllowed' => $courseInfoFieldsAllowed
        ]);
    }


}
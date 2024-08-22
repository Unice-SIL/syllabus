<?php


namespace App\Syllabus\Controller\Admin;


use App\Syllabus\Entity\CourseInfoField;
use App\Syllabus\Form\CourseInfo\ImportType;
use App\Syllabus\Helper\Report\ReportingHelper;
use App\Syllabus\Import\Configuration\CourseInfoCsvConfiguration;
use App\Syllabus\Import\Configuration\CoursePermissionCsvConfiguration;
use App\Syllabus\Import\Configuration\UserCsvConfiguration;
use App\Syllabus\Import\ImportManager;
use App\Syllabus\Manager\CourseInfoManager;
use App\Syllabus\Manager\CoursePermissionManager;
use App\Syllabus\Manager\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ImportController
 * @package App\Syllabus\Controller
 */
#[Route(path: '/import/csv', name: 'app.admin.import_csv.')]
class ImportController extends AbstractController
{

    /**
     * @throws Exception
     */
    #[Route(path: '/course-info', name: 'course_info', methods: ['GET', 'POST'])]
    public function courseInfo(
        Request $request,
        EntityManagerInterface $em,
        CourseInfoManager $courseInfoManager,
        ImportManager $importManager,
        CourseInfoCsvConfiguration $courseInfoCsvConfiguration,
        TranslatorInterface $translator
    ): RedirectResponse|Response
    {
        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {


            $courseInfoCsvConfiguration->setPath($form->getData()['file']->getPathName());
            $parsingReport = ReportingHelper::createReport($translator->trans('admin.import.reporting_helper.parsing'));
            $courseInfos = $importManager->parseFromConfig($courseInfoCsvConfiguration, $parsingReport, [
                'allow_extra_field' => true,
                'allow_less_field' => true,
            ]);


            $courseInfoFields = $em->getRepository(CourseInfoField::class)->findByAutomaticDuplication(true);
            $fieldsToUpdate = array_map(function ($courseInfoField) {
                return $courseInfoField->getField();
            }, $courseInfoFields);

            $fieldsToUpdate = array_intersect($fieldsToUpdate, $courseInfoCsvConfiguration->getExtractor()->getCsv()->getHeader());
            if(in_array('mccCtCoeffSession1', $fieldsToUpdate))
            {
                $fieldsToUpdate[] = 'mccCcCoeffSession1';
            }

            $validationReport = ReportingHelper::createReport($translator->trans('admin.import.reporting_helper.insertion_db'));

            foreach ($courseInfos as $lineIdReport => $courseInfo) {
                $courseInfoManager->updateIfExistsOrCreate($courseInfo, $fieldsToUpdate, [
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
            $request->getSession()->set('parsingCsvReport', $parsingReport);
            $request->getSession()->set('validationReport', $validationReport);
            return $this->redirectToRoute('app.admin.import_csv.course_info');

        }

        /*
        $courseInfoFieldsAllowed = array_filter(iterator_to_array($courseInfoCsvParser->getCompleteMatching()), function ($value, $key) use ($fieldsToUpdate){
            return in_array($key, $fieldsToUpdate) || (is_array($value) && array_key_exists('required', $value) && $value['required'] === true);
        }, ARRAY_FILTER_USE_BOTH);
        */
        $fieldsAllowed = iterator_to_array($courseInfoCsvConfiguration->getMatching()->getCompleteMatching());

        return $this->render('import/course_info.html.twig', [
            'form' => $form->createView(),
            'parsingCsvReport' => $request->getSession()->remove('parsingCsvReport'),
            'validationReport' => $request->getSession()->remove('validationReport'),
            'fieldsAllowed' => $fieldsAllowed
        ]);
    }


    /**
     * @throws Exception
     */
    #[Route(path: '/permission', name: 'permission', methods: ['GET', 'POST'])]
    public function permission(
        Request $request,
        CoursePermissionManager $coursePermissionManager,
        ImportManager $importManager,
        CoursePermissionCsvConfiguration $coursePermissionCsvConfiguration,
        TranslatorInterface $translator
    ): RedirectResponse|Response
    {

        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);

        $fieldsAllowed = iterator_to_array($coursePermissionCsvConfiguration->getMatching()->getCompleteMatching());

        if ($form->isSubmitted() && $form->isValid()) {

            $coursePermissionCsvConfiguration->setPath($form->getData()['file']->getPathName());
            $parsingReport = ReportingHelper::createReport($translator->trans('admin.import.reporting_helper.parsing'));
            $coursePermissions = $importManager->parseFromConfig($coursePermissionCsvConfiguration, $parsingReport, [
                'allow_extra_field' => false,
                'allow_less_field' => false,
            ]);

            $validationReport = ReportingHelper::createReport($translator->trans('admin.import.reporting_helper.insertion_db'));

            foreach ($coursePermissions as $lineIdReport => $coursePermission) {

                $coursePermissionManager->updateIfExistsOrCreate($coursePermission, ['permission'], [
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
            $request->getSession()->set('parsingCsvReport', $parsingReport);
            $request->getSession()->set('validationReport', $validationReport);
            return $this->redirectToRoute('app.admin.import_csv.permission');

        }

        return $this->render('import/permission.html.twig', [
            'form' => $form->createView(),
            'parsingCsvReport' => $request->getSession()->remove('parsingCsvReport'),
            'validationReport' => $request->getSession()->remove('validationReport'),
            'fieldsAllowed' => $fieldsAllowed
        ]);
    }

    /**
     * @throws Exception
     */
    #[Route(path: '/user', name: 'user', methods: ['GET', 'POST'])]
    public function user(
        Request $request,
        UserManager $userManager,
        ImportManager $importManager,
        UserCsvConfiguration $userCsvConfiguration,
        TranslatorInterface $translator
    ): RedirectResponse|Response
    {
        $form = $this->createForm(ImportType::class);
        $form->handleRequest($request);

        $fieldsAllowed = iterator_to_array($userCsvConfiguration->getMatching()->getCompleteMatching());
        $fieldsToUpdate = array_keys($fieldsAllowed);

        if ($form->isSubmitted() && $form->isValid()) {

            $userCsvConfiguration->setPath($form->getData()['file']->getPathName());
            $parsingReport = ReportingHelper::createReport($translator->trans('admin.import.reporting_helper.parsing'));
            $users = $importManager->parseFromConfig($userCsvConfiguration, $parsingReport,[
                'allow_extra_field' => false,
                'allow_less_field' => true,
            ]);
            $validationReport = ReportingHelper::createReport($translator->trans('admin.import.reporting_helper.insertion_db'));

            foreach ($users as $lineIdReport => $user) {

                $userManager->updateIfExistsOrCreate($user, $fieldsToUpdate, [
                    'flush' => true,
                    'find_by_parameters' => [
                        'username' => $user->getUsername(),
                    ],
                    'lineIdReport' => $lineIdReport,
                    'report' => $validationReport
                ]);
            }

            $validationReport->finishReport(count($users));
            $request->getSession()->set('parsingCsvReport', $parsingReport);
            $request->getSession()->set('validationReport', $validationReport);
            return $this->redirectToRoute('app.admin.import_csv.user');
        }

        return $this->render('import/user.html.twig', [
            'form' => $form->createView(),
            'parsingCsvReport' => $request->getSession()->remove('parsingCsvReport'),
            'validationReport' => $request->getSession()->remove('validationReport'),
            'fieldsAllowed' => $fieldsAllowed
        ]);
    }

}
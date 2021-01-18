<?php


namespace App\Syllabus\Import\Extractor;


use App\Syllabus\Helper\Report\Report;
use App\Syllabus\Helper\Report\ReportLine;
use App\Syllabus\Helper\Report\ReportMessage;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class CoursePermissionMoodleExtractor
 * @package AppBundle\Import\Extractor
 */
class CoursePermissionMoodleExtractor implements ExtractorInterface
{

    /**
     * @param Report|null $report
     * @param array $options
     * @return array
     * @throws GuzzleException
     */
    public function extract(Report $report = null, array $options = [])
    {
        if(empty($options['url']))
        {
            throw new \LogicException('moodle_api_url parameter must be defined in parameters.yml');
        }

        if(empty($options['token']))
        {
            throw new \LogicException('moodle_api_token parameter must be defined in parameters.yml');
        }

        $permissions = [];
        $url = $options['url'];
        $token = $options['token'];
        $restFormat = 'json';

        $client = new Client();

        $response = $client->request('GET', $url, [
            'query' => [
                'wsfunction' => 'core_course_get_courses',
                'wstoken' => $token,
                'moodlewsrestformat' => $restFormat
            ]
        ]);

        if($response->getStatusCode() != 200)
        {
            $message = new ReportMessage('Error while retrieve Moodle courses');
            $message->setType(ReportMessage::TYPE_DANGER);
            $report->addMessage($message);
            return [];
        }

        $courses = json_decode($response->getBody(), true);

        foreach ($courses as $course)
        {
            if (!array_key_exists('id', $course) || empty($course['id'])) {
                $message = new ReportLine('The course has no id');
                $report->addLine($message);
                continue;
            }
            $id = $course['id'];

            if (!array_key_exists('idnumber', $course) || empty($course['idnumber'])) {
                $message = new ReportLine("The course {$id} has no idnumber");
                $report->addLine($message);
                continue;
            }
            $code = $course['idnumber'];

            $response = $client->request('GET', $url, [
                'query' => [
                    'wsfunction' => 'core_enrol_get_enrolled_users_with_capability',
                    'coursecapabilities' => [
                        ['courseid' => $id, 'capabilities' => ['moodle/course:markcomplete']]
                    ],
                    'wstoken' => $token,
                    'moodlewsrestformat' => $restFormat
                ]
            ]);

            if($response->getStatusCode() != 200)
            {
                $message = new ReportLine("Error while retrieve course {$code} info");
                $report->addLine($message);
                continue;
            }

            $teachers = json_decode($response->getBody(), true);

            if (!array_key_exists(0, $teachers)) {
                $message = new ReportLine("Wrong response format when get teachers for course {$code} [{$id}] the key 0 does not exist");
                $report->addLine($message);
                continue;
            }
            $teachers = $teachers[0];

            if (!array_key_exists('users', $teachers)) {
                $message = new ReportLine("Wrong response format when get teachers for course {$code} [{$id}] the key users does not exist");
                $report->addLine($message);
                continue;
            }
            $teachers = $teachers['users'];

            foreach ($teachers as $teacher) {
                if (!array_key_exists('id', $teacher) || empty($teacher['id'])) {
                    $message = new ReportLine("Teacher has no id for course {$code} [{$id}]");
                    $report->addLine($message);
                    continue;
                }
                $tid = $teacher['id'];

                if (!array_key_exists('username', $teacher) || empty($teacher['username'])) {
                    $message = new ReportLine("Teacher {$tid} has no username for course {$code} [{$id}]");
                    $report->addLine($message);
                    continue;
                }
                $username = $teacher['username'];

                $permissions[] = [
                    'username' => $teacher['username'],
                    'firstname' => $teacher['firstname'],
                    'lastname' => $teacher['lastname'],
                    'email' => $teacher['email'],
                    'code' => $code
                ];
            }
        }

        return $permissions;
    }

}
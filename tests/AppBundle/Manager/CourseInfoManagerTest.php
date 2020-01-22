<?php


namespace Tests\AppBundle\Manager;


use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseInfoField;
use AppBundle\Entity\CourseSection;
use AppBundle\Entity\CourseTeacher;
use AppBundle\Entity\Structure;
use AppBundle\Entity\User;
use AppBundle\Helper\Report\Report;
use AppBundle\Manager\CourseInfoManager;
use AppBundle\Repository\Doctrine\CourseInfoDoctrineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class CourseInfoManagerTest extends TestCase
{
    const COURSE_INFO_SENDER_ETBID = 'SLEP111';
    const COURSE_INFO_SENDER_YEAR = '2018';
    const COURSE_INFO_RECIPIENT_ETBID = 'SLEP111';
    const COURSE_INFO_RECIPIENT_YEAR = '2019';
    const COURSE_INFO_CORRECT_UNION_ID = '__UNION__';

    /**
     * @dataProvider duplicateProvider
     * @param bool $currentUser
     * @param bool $courseInfoFields
     * @param string|null $courseInfoSenderId
     * @param string|null $courseInfoRecipientId
     * @param int $messageCountExpected
     * @param int $commentLineExpected
     * @throws \Exception
     */
    public function testDuplicate(bool $currentUser, bool $courseInfoFields, ?string $courseInfoSenderId, ?string $courseInfoRecipientId, int $messageCountExpected, int $commentLineExpected)
    {

        // Get courseInfoManagerMock
        $courseInfoSender =  new CourseInfo();
        $courseInfoRecipient =  new CourseInfo();
        $courseInfoManagerMock = $this->getCourseInfoManagerMockForTestingDuplicate($currentUser,$courseInfoFields, $courseInfoSender, $courseInfoRecipient);

        // Using duplicate function on $courseInfoManagerMock
        $result = $courseInfoManagerMock->duplicate($courseInfoSenderId, $courseInfoRecipientId, CourseInfoManager::DUPLICATION_CONTEXTE_MANUALLY); //the context doesn't matter

        // Asserting of duplicate function return
        // The result should be of type AppBundle\Helper\Report\Report
        $this->assertInstanceOf(Report::class, $result);

        // Asserting Messages Count
        $this->assertCount($messageCountExpected, $result->getMessages());

        // Asserting Comment Line Count
        foreach ($result->getLines() as $line) {
            $this->assertCount($commentLineExpected, $line->getComments());
        }

        if ($messageCountExpected === 0 and $commentLineExpected === 0) {

            $propertyAccessor = PropertyAccess::createPropertyAccessor();

            foreach ($this->getFieldDuplicationTest() as $field => $value) {

                if ($value instanceof Collection) {
                    $arrayCollectionRecipient = $propertyAccessor->getValue($courseInfoRecipient, $field);

                    $this->assertEquals($arrayCollectionRecipient->count(), $value->count());
                    $i = 0;
                    foreach ($value as $item) {
                        $itemFromRecipient = $arrayCollectionRecipient->offsetGet($i++);
                        $this->assertNotEquals($itemFromRecipient->getId(), $item->getId());
                        $item->setCourseInfo(null);
                        $item->setId(null);
                        $itemFromRecipient->setCourseInfo(null);
                        $itemFromRecipient->setId(null);

                        //Uncomment if you want to test an error of duplication
                        /*if ($item instanceof CourseTeacher) {
                            $item->setFirstname('azer');
                        }*/
                    }
                }

                $this->assertEquals($value, $propertyAccessor->getValue($courseInfoRecipient, $field));
            }
        }


    }

    /**
     * @return array
     * @throws \Exception
     */
    private function getFieldDuplicationTest()
    {
        $courseTeacher = new CourseTeacher();
        $courseTeacher->setId(Uuid::uuid4());
        $courseTeacher->setFirstname('firstname');

        $courseSection = new CourseSection();
        $courseSection->setId(Uuid::uuid4());
        $courseSection->setTitle('title of course Section fake 1');
        return [
            'structure' => new Structure(),
            'title' => 'fake title',
            'ects' => 'fake ects',
            'level' => 'fake level',
            'languages' => 'fake languages',
            'domain' => 'fake domain',
            'semester' => 'fake semester',
            'summary' => 'fake summary',
            'period' => 'fake period',
            'mediaType' => 'fake mediaType',
            'image' => 'fake image',
            'video' => 'fake video',
            'teachingMode' => 'fake teachingMode',
            'teachingCmClass' => 'fake teachingCmClass',
            'teachingTdClass' => 'fake teachingTdClass',
            'teachingTpClass' => 'fake teachingTpClass',
            'teachingOtherClass' => 'fake teachingOtherClass',
            'teachingOtherTypeClass' => 'fake teachingOtherTypeClass',
            'teachingCmHybridClass' => 'fake teachingCmHybridClass',
            'teachingTdHybridClass' => 'fake teachingTdHybridClass',
            'teachingTpHybridClass' => 'fake teachingTpHybridClass',
            'teachingOtherHybridClass' => 'fake teachingOtherHybridClass',
            'teachingOtherTypeHybridClass' => 'fake teachingOtherTypeHybridClass',
            'teachingCmHybridDist' => 'fake teachingCmHybridDist',
            'teachingTdHybridDist' => 'fake teachingTdHybridDist',
            'teachingOtherHybridDist' => 'fake teachingOtherHybridDist',
            'teachingOtherTypeHybridDistant' => 'fake teachingOtherTypeHybridDistant',
            'mccWeight' => 'fake mccWeight',
            'mccCompensable' => true,
            'mccCapitalizable' => true,
            'mccCcCoeffSession1' => 'fake mccCcCoeffSession1',
            'mccCcNbEvalSession1' => 1,
            'mccCtCoeffSession1' => 'fake mccCtCoeffSession1',
            'mccCtNatSession1' => 'fake mccCtNatSession1',
            'mccCtDurationSession1' => 'fake mccCtDurationSession1',
            'mccCtCoeffSession2' => 'fake mccCtCoeffSession2',
            'mccCtNatSession2' => 'fake mccCtNatSession2',
            'mccCtDurationSession2' => 'fake mccCtDurationSession2',
            'mccAdvice' => 'fake mccAdvice',
            'tutoring' => true,
            'tutoringTeacher' => true,
            'tutoringStudent' => true,
            'tutoringDescription' => 'fake tutoringDescription',
            'educationalResources' => 'fake educationalResources',
            'bibliographicResources' => 'fake bibliographicResources',
            'agenda' => 'fake agenda',
            'organization' => 'fake organization',
            'closingRemarks' => 'fake closingRemarks',
            'closingVideo' => 'fake closingVideo',
            'courseTeachers' => new ArrayCollection([$courseTeacher]),
            'courseSections' => new ArrayCollection([$courseSection]),
            //'courseEvaluationCts' => new ArrayCollection(),
            //'courseAchievements' => new ArrayCollection(),
            //'coursePrerequisites' => new ArrayCollection(),
            //'courseTutoringResources' => new ArrayCollection(),
            //'courseResourceEquipments' => new ArrayCollection(),
        ];
    }

    /**
     * Return a provider for testDuplicate function
     *
     * @return array
     */
    public function duplicateProvider()
    {
        // data1 : current User
        // data2 : courseInfoField find in db
        // data3 : courseInfoSender
        // data4 : courseInfoRecipient
        // data5 : messageCountExpected
        // data6 : commentLineExpected
        return [
            'no_user_authenticate'  => [
                false,
                true,
                self::COURSE_INFO_SENDER_ETBID . self::COURSE_INFO_CORRECT_UNION_ID . self::COURSE_INFO_SENDER_YEAR,
                self::COURSE_INFO_RECIPIENT_ETBID . self::COURSE_INFO_CORRECT_UNION_ID . self::COURSE_INFO_RECIPIENT_YEAR,
                1,
                0
            ],
            'no_course_info_field_activate'  => [
                true,
                false,
                self::COURSE_INFO_SENDER_ETBID . self::COURSE_INFO_CORRECT_UNION_ID . self::COURSE_INFO_SENDER_YEAR,
                self::COURSE_INFO_RECIPIENT_ETBID . self::COURSE_INFO_CORRECT_UNION_ID . self::COURSE_INFO_RECIPIENT_YEAR,
                1,
                0
            ],
            'course_info_sender_wrong_format'  => [
                true,
                true,
                self::COURSE_INFO_SENDER_ETBID . '__UNION' . self::COURSE_INFO_SENDER_YEAR,
                self::COURSE_INFO_RECIPIENT_ETBID . self::COURSE_INFO_CORRECT_UNION_ID . self::COURSE_INFO_RECIPIENT_YEAR,
                1,
                0
            ],
            'course_info_recipient_wrong_format'  => [
                true,
                true,
                self::COURSE_INFO_SENDER_ETBID . self::COURSE_INFO_CORRECT_UNION_ID . self::COURSE_INFO_SENDER_YEAR,
                self::COURSE_INFO_RECIPIENT_ETBID . '__UNION' . self::COURSE_INFO_RECIPIENT_YEAR,
                1,
                0
            ],
            'course_info_sender_same_as_recipient'  => [
                true,
                true,
                self::COURSE_INFO_SENDER_ETBID . self::COURSE_INFO_CORRECT_UNION_ID . self::COURSE_INFO_SENDER_YEAR,
                self::COURSE_INFO_SENDER_ETBID . self::COURSE_INFO_CORRECT_UNION_ID . self::COURSE_INFO_SENDER_YEAR,
                0,
                1
            ],
            'no_course_info_sender_find_in_db'  => [
                true,
                true,
                self::COURSE_INFO_SENDER_ETBID . self::COURSE_INFO_CORRECT_UNION_ID . '2089',
                self::COURSE_INFO_RECIPIENT_ETBID . self::COURSE_INFO_CORRECT_UNION_ID . self::COURSE_INFO_RECIPIENT_YEAR,
                0,
                1
            ],
            'no_course_info_recipient_find_in_db'  => [
                true,
                true,
                self::COURSE_INFO_SENDER_ETBID . self::COURSE_INFO_CORRECT_UNION_ID . self::COURSE_INFO_SENDER_YEAR,
                self::COURSE_INFO_RECIPIENT_ETBID . self::COURSE_INFO_CORRECT_UNION_ID . '2087',
                0,
                1
            ],
            'no_errors'  => [
                true,
                true,
                self::COURSE_INFO_SENDER_ETBID . self::COURSE_INFO_CORRECT_UNION_ID . self::COURSE_INFO_SENDER_YEAR,
                self::COURSE_INFO_RECIPIENT_ETBID . self::COURSE_INFO_CORRECT_UNION_ID . self::COURSE_INFO_RECIPIENT_YEAR,
                0,
                0
            ],
        ];
    }

    /**
     * Return a mock of $courseInfoManager to test the duplicate function
     *
     * @param bool $hasUser
     * @param bool $hasCourseInfoFileds
     * @param CourseInfo $courseInfoSender
     * @param CourseInfo $courseInfoRecipient
     * @return CourseInfoManager
     * @throws \Exception
     */
    private function getCourseInfoManagerMockForTestingDuplicate(bool $hasUser, bool $hasCourseInfoFileds,  CourseInfo $courseInfoSender, CourseInfo $courseInfoRecipient)
    {
        // Mock entity manager
        $courseInfoFields = [];
        if ($hasCourseInfoFileds) {
            foreach ($this->getFieldDuplicationTest() as $field => $value) {
                $courseInfoFields[] = new CourseInfoField($field);
            }
        }
        $em = $this
            ->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['getRepository', 'findByManuallyDuplication'])
            ->getMock();
        $em->expects($this->any())
            ->method('getRepository')
            ->with(CourseInfoField::class)
            ->will($this->returnSelf());
        $em->expects($this->any())
            ->method('findByManuallyDuplication')
            ->will($this->returnValue($courseInfoFields));

        // Mock course info repository
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach ($this->getFieldDuplicationTest() as $field => $value) {
            if ($value instanceof Collection) {
                foreach ($value as $item) {
                    $item->setCourseInfo($courseInfoSender);
                }
            }
            $propertyAccessor->setValue($courseInfoSender, $field, $value);
        }
        $courseInfoRepository = $this
            ->getMockBuilder(CourseInfoDoctrineRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $courseInfoRepository->expects($this->any())
            ->method('findByEtbIdAndYear')
            ->will($this->returnValueMap([
                [self::COURSE_INFO_SENDER_ETBID, self::COURSE_INFO_SENDER_YEAR, $courseInfoSender],
                [self::COURSE_INFO_RECIPIENT_ETBID, self::COURSE_INFO_RECIPIENT_YEAR, $courseInfoRecipient]
            ]));

        // Mock token storage
        $tokenStorage = $this
            ->getMockBuilder(TokenStorage::class)
            ->disableOriginalConstructor()
            ->setMethods(['getToken', 'getUser'])
            ->getMock();
        $tokenStorage->expects($this->any())
            ->method('getToken')
            ->will($this->returnSelf());
        $tokenStorage->expects($this->any())
            ->method('getUser')
            ->will($this->returnValue($hasUser ? new User() : null));

        // Instantiation of CourseInfoManager
        return new CourseInfoManager($courseInfoRepository, $em, $tokenStorage);
    }

}
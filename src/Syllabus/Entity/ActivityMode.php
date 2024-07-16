<?php

namespace App\Syllabus\Entity;

use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * ActivityMode
 *
 * @ORM\Table(name="activity_mode")
 * @ORM\Entity(repositoryClass="App\Syllabus\Repository\Doctrine\ActivityModeDoctrineRepository")
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\ActivityModeTranslation")
 */
#[
    ApiResource(
        operations: [
            new Get(security: 'is_granted(\'ROLE_API_ACTIVITY_MODE_GET\')'),
            new Put(security: 'is_granted(\'ROLE_API_ACTIVITY_MODE_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_ACTIVITY_MODE_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_ACTIVITY_MODE_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_ACTIVITY_MODE_POST\')')
        ],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter'],
        security: 'is_granted(\'ROLE_API_ACTIVITY_MODE\')'
    )
]
#[
    ApiResource(
        uriTemplate: '/activities/{id}/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: ['id']),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/activity_modes/{id}/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'activityModes', fromClass: self::class, identifiers: ['id']),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/activity_types/{id}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: [], expandedValue: 'activity_type')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_mode'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: [], expandedValue: 'activity_type')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_mode'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: [], expandedValue: 'activity_type')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_mode'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: [], expandedValue: 'activity_type')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_mode'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: [], expandedValue: 'activity_type')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_mode'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: [], expandedValue: 'activity_type')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_mode'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: [], expandedValue: 'activity_type')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_mode'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: [], expandedValue: 'activity_type')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_mode'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: [], expandedValue: 'activity_type')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_mode'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: [], expandedValue: 'activity_type')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_mode'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: [], expandedValue: 'activity_type')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_mode'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_sections/{id}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: [], expandedValue: 'activity_type')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_sections/{id}/course_section_activities/{courseSectionActivities}/activity_mode.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_sections/{id}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_mode'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/activity/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/activity_type/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: [], expandedValue: 'activity_type')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/activity_mode.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/activity_mode/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_mode'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/course_section/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'courseSection' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: [], expandedValue: 'course_section'),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/course_section/course_section_activities/{courseSectionActivities}/activity_type/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'courseSection' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: [], expandedValue: 'course_section'),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: [], expandedValue: 'activity_type')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/course_section/course_section_activities/{courseSectionActivities}/activity_mode.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'courseSection' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: [], expandedValue: 'course_section'),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/course_section/course_section_activities/{courseSectionActivities}/activity_mode/activity_types/{activityTypes}/activity_modes.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'courseSection' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: [], expandedValue: 'course_section'),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_mode'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: ActivityType::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]

class ActivityMode
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=36, unique=true, options={"fixed"=true})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
     */
    private string $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=100, nullable=false)
     * @Assert\NotBlank()
     * @Gedmo\Translatable
     */
    private string $label;

    /**
     * @var bool
     *
     * @ORM\Column(name="obsolete", type="boolean", nullable=false)
     */
    private bool $obsolete = false;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Syllabus\Entity\ActivityType", mappedBy="activityModes")
     */
    private Collection $activityTypes;

    /**
     * ActivityMode constructor.
     */
    public function __construct()
    {
        $this->activityTypes = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param null|string $id
     * @return ActivityMode
     */
    public function setId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string|null $label
     * @return $this
     */
    public function setLabel(?string $label): self
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return bool
     */
    public function isObsolete(): bool
    {
        return $this->obsolete;
    }

    /**
     * @param bool $obsolete
     * @return ActivityMode
     */
    public function setObsolete(bool $obsolete): self
    {
        $this->obsolete = $obsolete;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getActivityTypes(): Collection
    {
        return $this->activityTypes;
    }

    /**
     * @param Collection $activityTypes
     * @return ActivityMode
     */
    public function setActivityTypes(Collection $activityTypes): self
    {
        $this->activityTypes = $activityTypes;
        return $this;
    }

    /**
     * @param ActivityType $activityType
     * @return ActivityMode
     */
    public function addActivityType(ActivityType $activityType): self
    {
        if (!$this->activityTypes->contains($activityType))
        {
            $this->activityTypes->add($activityType);
            if (!$activityType->getActivityModes()->contains($this))
            {
                $activityType->getActivityModes()->add($this);
            }
        }
        return $this;
    }

    /**
     * @param ActivityType $activityType
     * @return ActivityMode
     */
    public function removeActivityType(ActivityType $activityType): self
    {
        if ($this->activityTypes->contains($activityType))
        {
            $this->activityTypes->removeElement($activityType);
            if ($activityType->getActivityModes()->contains($this))
            {
                $activityType->getActivityModes()->removeElement($this);
            }
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getLabel();
    }
}
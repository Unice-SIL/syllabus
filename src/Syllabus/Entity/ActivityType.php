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
use Doctrine\ORM\Mapping\JoinTable;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Activity
 *
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\ActivityTypeTranslation")
 */
#[
    ApiResource(
        operations: [
            new Get(security: 'is_granted(\'ROLE_API_ACTIVITY_TYPE_GET\')'),
            new Put(security: 'is_granted(\'ROLE_API_ACTIVITY_TYPE_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_ACTIVITY_TYPE_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_ACTIVITY_TYPE_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_ACTIVITY_TYPE_POST\')')
        ],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter'],
        security: 'is_granted(\'ROLE_API_ACTIVITY_TYPE\')'
    )
]
#[
    ApiResource(
        uriTemplate: '/activities/{id}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/activities/{id}/activity_types/{activityTypes}/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: ['id']),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: ['id']),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/activity_modes/{id}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/activity_types/{id}/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: ['id']),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: ['id']),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_type'),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: [], expandedValue: 'activity_mode')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: ['id']),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_type'),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: [], expandedValue: 'activity_mode')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: ['id']),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_type'),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: [], expandedValue: 'activity_mode')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: ['id']),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_type'),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: [], expandedValue: 'activity_mode')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: ['id']),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_type'),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: [], expandedValue: 'activity_mode')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes/{activityModes}/activity_types.{_format}',
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
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: ['id']),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_type'),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: [], expandedValue: 'activity_mode')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: ['id']),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_type'),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: [], expandedValue: 'activity_mode')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes/{activityModes}/activity_types.{_format}',
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
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: ['id']),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_type'),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: [], expandedValue: 'activity_mode')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: ['id']),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_type'),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: [], expandedValue: 'activity_mode')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: ['id']),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_type'),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: [], expandedValue: 'activity_mode')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: ['id']),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_type'),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course_sections/{courseSections}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseInfo', fromClass: CourseInfo::class, identifiers: ['id']),
            'courseSections' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: [], expandedValue: 'activity_mode')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_sections/{id}/course_section_activities/{courseSectionActivities}/activity/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_sections/{id}/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: ['id']),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_sections/{id}/course_section_activities/{courseSectionActivities}/activity_type.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_sections/{id}/course_section_activities/{courseSectionActivities}/activity_type/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_type'),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_sections/{id}/course_section_activities/{courseSectionActivities}/activity_mode/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: ['id']),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: [], expandedValue: 'activity_mode')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/activity/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/activity/activity_types/{activityTypes}/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: ['id']),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/activity_type.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/activity_type/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_type'),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/activity_mode/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: [], expandedValue: 'activity_mode')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/course_section/course_section_activities/{courseSectionActivities}/activity/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'courseSection' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: [], expandedValue: 'course_section'),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/course_section/course_section_activities/{courseSectionActivities}/activity/activity_types/{activityTypes}/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'courseSection' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: [], expandedValue: 'course_section'),
            'courseSectionActivities' => new Link(fromProperty: 'activity', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activity' => new Link(toProperty: 'activities', fromClass: Activity::class, identifiers: [], expandedValue: 'activity'),
            'activityTypes' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: ['id']),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/course_section/course_section_activities/{courseSectionActivities}/activity_type.{_format}',
        operations: [new Get()],
        uriVariables: [
            'id' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'courseSection' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: [], expandedValue: 'course_section'),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/course_section/course_section_activities/{courseSectionActivities}/activity_type/activity_modes/{activityModes}/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'courseSection' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: [], expandedValue: 'course_section'),
            'courseSectionActivities' => new Link(fromProperty: 'activityType', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityType' => new Link(fromProperty: 'activityModes', fromClass: self::class, identifiers: [], expandedValue: 'activity_type'),
            'activityModes' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_section_activities/{id}/course_section/course_section_activities/{courseSectionActivities}/activity_mode/activity_types.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'courseSection', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'courseSection' => new Link(toProperty: 'courseSection', fromClass: CourseSection::class, identifiers: [], expandedValue: 'course_section'),
            'courseSectionActivities' => new Link(fromProperty: 'activityMode', fromClass: CourseSectionActivity::class, identifiers: ['id']),
            'activityMode' => new Link(toProperty: 'activityModes', fromClass: ActivityMode::class, identifiers: [], expandedValue: 'activity_mode')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[ORM\Entity(repositoryClass: \App\Syllabus\Repository\Doctrine\ActivityTypeDoctrineRepository::class)]
#[ORM\Table(name: 'activity_type')]
class ActivityType
{
    
    #[ORM\Column(type: 'string', length: 36, unique: true, options: ['fixed' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private string $id;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'label', type: 'string', length: 100, nullable: false)]
    #[Assert\NotBlank]
    private string $label;

    
    #[ORM\Column(name: 'icon', type: 'text', length: 65535, nullable: true)]
    #[Assert\File(maxSize: '2M', mimeTypes: ['image/jpeg', 'image/png'])]
    private ?string $icon = null;

    private ?string $previousIcon = null;

    
    #[ORM\Column(name: 'obsolete', type: 'boolean', nullable: false)]
    private bool $obsolete = false;

    
    #[ORM\ManyToMany(targetEntity: Activity::class, inversedBy: 'activityTypes')]
    #[JoinTable(name: 'activity_type_activity')]
    private Collection $activities;

    
    #[ORM\ManyToMany(targetEntity: ActivityMode::class, inversedBy: 'activityTypes')]
    #[JoinTable(name: 'activity_type_activity_mode')]
    private Collection $activityModes;

    /**
     * ActivityType constructor.
     */
    public function __construct()
    {
        $this->activityModes = new ArrayCollection();
        $this->activities = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(mixed $icon): void
    {
        $this->icon = $icon;
    }

    public function getPreviousIcon(): ?string
    {
        return $this->previousIcon;
    }

    /**
     * @param $previousIcon
     */
    public function setPreviousIcon($previousIcon): ActivityType
    {
        $this->previousIcon = $previousIcon;
        return $this;
    }

    public function isObsolete(): bool
    {
        return $this->obsolete;
    }

    public function setObsolete(bool $obsolete): self
    {
        $this->obsolete = $obsolete;
        return $this;
    }

    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function setActivities(Collection $activities): self
    {
        $this->activities = $activities;
        return $this;
    }

    public function getActivityModes(): Collection
    {
        return $this->activityModes;
    }

    public function setActivityModes(Collection $activityModes): self
    {
        $this->activityModes = $activityModes;
        return $this;
    }

    public function addActivity(Activity $activity): self
    {
        if (!$this->activities->contains($activity))
        {
            $this->activities->add($activity);
            if (!$activity->getActivityTypes()->contains($this))
            {
                $activity->getActivityTypes()->add($this);
            }
        }
        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        if ($this->activities->contains($activity))
        {
            $this->activities->removeElement($activity);
            if ($activity->getActivityTypes()->contains($this))
            {
                $activity->getActivityTypes()->removeElement($this);
            }
        }
        return $this;
    }

    public function addActivityMode(ActivityMode $activityMode): self
    {
        if (!$this->activityModes->contains($activityMode))
        {
            $this->activityModes->add($activityMode);
            if (!$activityMode->getActivityTypes()->contains($this))
            {
                $activityMode->getActivityTypes()->add($this);
            }
        }
        return $this;
    }

    public function removeActivityMode(ActivityMode $activityMode): self
    {
        if ($this->activityModes->contains($activityMode))
        {
            $this->activityModes->removeElement($activityMode);
            if ($activityMode->getActivityTypes()->contains($this))
            {
                $activityMode->getActivityTypes()->removeElement($this);
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
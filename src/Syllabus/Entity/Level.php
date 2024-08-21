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
use App\Syllabus\Traits\Importable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Level
 * @package App\Syllabus\Entity
 */
#[
    ApiResource(
        operations: [
            new Get(security: 'is_granted(\'ROLE_API_LEVEL_GET\')'),
            new Put(security: 'is_granted(\'ROLE_API_LEVEL_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_LEVEL_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_LEVEL_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_LEVEL_POST\')')
        ],
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter'],
        security: 'is_granted(\'ROLE_API_LEVEL\')'
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/structure/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure'),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/structure/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'domains', fromClass: CourseInfo::class, identifiers: ['id']),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'levels', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/structure/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure'),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/structure/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'domains', fromClass: CourseInfo::class, identifiers: ['id']),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/parents/{parents}/course_infos/{courseInfos}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'levels', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/structure/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure'),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/structure/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: ['id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'domains', fromClass: CourseInfo::class, identifiers: ['id']),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'levels', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/structure/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure'),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/structure/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'domains', fromClass: CourseInfo::class, identifiers: ['id']),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/childrens/{children}/course_infos/{courseInfos}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'levels', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/structure/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure'),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/structure/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'domains', fromClass: CourseInfo::class, identifiers: ['id']),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/courses/{id}/course_infos/{courseInfos}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'levels', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/structure/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure'),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/structure/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'domains', fromClass: CourseInfo::class, identifiers: ['id']),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/childrens/{children}/course_infos/{courseInfos}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(fromClass: Course::class, identifiers: ['id']),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'levels', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/structure/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure'),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/structure/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'domains', fromClass: CourseInfo::class, identifiers: ['id']),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/parents/{parents}/course_infos/{courseInfos}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'levels', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/structure/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure'),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/structure/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'domains', fromClass: CourseInfo::class, identifiers: ['id']),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/parents/{parents}/course_infos/{courseInfos}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(fromClass: Course::class, identifiers: ['id']),
            'parents' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'levels', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/structure/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure'),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/structure/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'domains', fromClass: CourseInfo::class, identifiers: ['id']),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/childrens/{children}/course_infos/{courseInfos}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'children' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: ['id']),
            'courseInfos' => new Link(fromProperty: 'levels', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/structure/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure'),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/structure/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(fromProperty: 'domains', fromClass: CourseInfo::class, identifiers: ['id']),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/course/course_infos/{courseInfos}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'course', fromClass: CourseInfo::class, identifiers: ['id']),
            'course' => new Link(toProperty: 'course', fromClass: Course::class, identifiers: [], expandedValue: 'course'),
            'courseInfos' => new Link(fromProperty: 'levels', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/structure/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure'),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/structure/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'structure', fromClass: CourseInfo::class, identifiers: ['id']),
            'structure' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: [], expandedValue: 'structure')
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'domains', fromClass: CourseInfo::class, identifiers: ['id']),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/course_infos/{id}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'levels', fromClass: CourseInfo::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/domains/{id}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/structures/{id}/domains/{domains}/structures/{structures}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id']),
            'domains' => new Link(fromProperty: 'structures', fromClass: Domain::class, identifiers: ['id']),
            'structures' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[
    ApiResource(
        uriTemplate: '/structures/{id}/levels.{_format}',
        operations: [new GetCollection()],
        uriVariables: [
            'id' => new Link(toProperty: 'structures', fromClass: Structure::class, identifiers: ['id'])
        ],
        status: 200,
        filters: ['id.search_filter', 'label.search_filter', 'obsolete.boolean_filter']
    )
]
#[ORM\Entity(repositoryClass: \App\Syllabus\Repository\Doctrine\LevelDoctrineRepository::class)]
#[ORM\Table(name: 'level')]
class Level
{

    use Importable;

    
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
    #[Assert\Length(max: 100)]
    private string $label;

    
    #[ORM\ManyToMany(targetEntity: Structure::class, inversedBy: 'levels')]
    #[ORM\OrderBy(['label' => 'ASC'])]
    private Collection $structures;

    
    #[ORM\Column(name: 'obsolete', type: 'boolean', nullable: false)]
    private bool $obsolete = false;

    /**
     * Level constructor.
     */
    public function __construct()
    {
        $this->structures = new ArrayCollection();
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

    public function isObsolete(): bool
    {
        return $this->obsolete;
    }

    /**
     * @param $obsolete
     */
    public function setObsolete($obsolete): self
    {
        $this->obsolete = $obsolete;

        return $this;
    }


    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getLabel();
    }

    /**
     * @return Collection
     */
    public function getStructures(): ?Collection
    {
        return $this->structures;
    }

    public function setStructures(Collection $structures): Level
    {
        $this->structures = $structures;
        return $this;
    }

    public function addStructure(Structure $structure): self
    {
        if (!$this->structures->contains($structure))
        {
            $this->structures->add($structure);
            if (!$structure->getLevels()->contains($this))
            {
                $structure->getLevels()->add($this);
            }
        }
        return $this;
    }

    public function removeStructure(Structure $structure): self
    {
        if ($this->structures->contains($structure))
        {
            $this->structures->removeElement($structure);
            if ($structure->getLevels()->contains($this))
            {
                $structure->getLevels()->removeElement($this);
            }
        }
        return $this;
    }

}
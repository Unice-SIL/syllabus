<?php

namespace App\Syllabus\Import\Extractor;

use App\Syllabus\Helper\Report\Report;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\FetchMode;

class CoursePermissionMoodleDoctrineExtractor implements ExtractorInterface
{
    /**
     * @var mixed
     */
    protected mixed $host;

    /**
     * @var mixed
     */
    protected mixed $port;

    /**
     * @var mixed
     */
    protected mixed $dbname;

    /**
     * @var mixed
     */
    protected mixed $driver;

    /**
     * @var mixed
     */
    protected mixed $user;

    /**
     * @var mixed
     */
    protected mixed $password;

    /**
     * @var mixed|string
     */
    protected mixed $charset;

    /**
     * @var mixed
     */
    protected mixed $tablePrefix;

    /**
     * @param array $moodlePermissionDbImporterOptions
     */
    public function __construct(array $moodlePermissionDbImporterOptions)
    {
        $this->driver = $moodlePermissionDbImporterOptions['driver'];
        $this->host = $moodlePermissionDbImporterOptions['host'];
        $this->port = $moodlePermissionDbImporterOptions['port'];
        $this->dbname = $moodlePermissionDbImporterOptions['database'];
        $this->user = $moodlePermissionDbImporterOptions['user'];
        $this->password = $moodlePermissionDbImporterOptions['password'];
        $this->charset = $moodlePermissionDbImporterOptions['charset']?? 'utf8';
        $this->tablePrefix = $moodlePermissionDbImporterOptions['table_prefix'];
    }

    /**
     * @return Connection
     * @throws Exception
     */
    private function getConnection(): Connection
    {
        return DriverManager::getConnection([
            'dbname' => $this->dbname,
            'user' => $this->user,
            'password' => $this->password,
            'host' => $this->host,
            'driver' => $this->driver
        ]);
    }

    /**
     * @param $tablename
     * @return string
     */
    private function getTablename($tablename): string
    {
        return $this->tablePrefix . $tablename;
    }

    /**
     * @param Report|null $report
     * @param array $options
     * @return mixed
     * @throws Exception
     */
    public function extract(Report $report = null, array $options = []): mixed
    {
        $conn = $this->getConnection();
        $sql  = 'SELECT '.
            $this->getTableName('user').'.username,  '.
            $this->getTableName('user').'.firstname, '.
            $this->getTableName('user').'.lastname, '.
            $this->getTableName('user').'.email, '.
            $this->getTableName('course').'.idnumber code
        FROM '.$this->getTableName('user').' 
        INNER JOIN '.$this->getTableName('role_assignments').' ON ('.$this->getTableName('role_assignments').'.userid = '.$this->getTableName('user').'.id) 
        INNER JOIN '.$this->getTableName('context').' ON ('.$this->getTableName('context').'.id = '.$this->getTableName('role_assignments').'.contextid) 
        INNER JOIN '.$this->getTableName('course').' ON ('.$this->getTableName('course').'.id = '.$this->getTableName('context').'.instanceid) 
        INNER JOIN '.$this->getTableName('role_capabilities').' ON ('.$this->getTableName('role_capabilities').'.roleid = '.$this->getTableName('role_assignments').'.roleid)
        WHERE '.$this->getTableName('course').'.idnumber IS NOT NULL 
        AND '.$this->getTableName('role_capabilities').'.capability = :capability';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('capability', 'moodle/course:markcomplete');
        $stmt->execute();
        $res = $stmt->fetchAll(FetchMode::ASSOCIATIVE);
        return $res;
    }
}
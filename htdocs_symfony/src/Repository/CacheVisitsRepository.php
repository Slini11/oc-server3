<?php

namespace Oc\Repository;

use DateTime;
use Doctrine\DBAL\Connection;
use Oc\Entity\GeoCacheVisitsEntity;
use Oc\Repository\Exception\RecordAlreadyExistsException;
use Oc\Repository\Exception\RecordNotFoundException;
use Oc\Repository\Exception\RecordNotPersistedException;
use Oc\Repository\Exception\RecordsNotFoundException;

class CacheVisitsRepository
{
    const TABLE = 'cache_visits';

    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return array
     * @throws RecordsNotFoundException
     */
    public function fetchAll()
    {
        $statement = $this->connection->createQueryBuilder()
            ->select('*')
            ->from(self::TABLE)
            ->execute();

        $result = $statement->fetchAll();

        if ($statement->rowCount() === 0) {
            throw new RecordsNotFoundException('No records found');
        }

        $records = [];

        foreach ($result as $item) {
            $records[] = $this->getEntityFromDatabaseArray($item);
        }

        return $records;
    }

    /**
     * @param array $where
     *
     * @return GeoCacheVisitsEntity
     * @throws RecordNotFoundException
     */
    public function fetchOneBy(array $where = [])
    {
        $queryBuilder = $this->connection->createQueryBuilder()
            ->select('*')
            ->from(self::TABLE)
            ->setMaxResults(1);

        if (count($where) > 0) {
            foreach ($where as $column => $value) {
                $queryBuilder->andWhere($column . ' = ' . $queryBuilder->createNamedParameter($value));
            }
        }

        $statement = $queryBuilder->execute();

        $result = $statement->fetch();

        if ($statement->rowCount() === 0) {
            throw new RecordNotFoundException('Record with given where clause not found');
        }

        return $this->getEntityFromDatabaseArray($result);
    }

    /**
     * @param array $where
     *
     * @return array
     * @throws RecordsNotFoundException
     */
    public function fetchBy(array $where = [])
    {
        $queryBuilder = $this->connection->createQueryBuilder()
            ->select('*')
            ->from(self::TABLE);

        if (count($where) > 0) {
            foreach ($where as $column => $value) {
                $queryBuilder->andWhere($column . ' = ' . $queryBuilder->createNamedParameter($value));
            }
        }

        $statement = $queryBuilder->execute();

        $result = $statement->fetchAll();

        if ($statement->rowCount() === 0) {
            throw new RecordsNotFoundException('No records with given where clause found');
        }

        $entities = [];

        foreach ($result as $item) {
            $entities[] = $this->getEntityFromDatabaseArray($item);
        }

        return $entities;
    }

    /**
     * @param array $where
     *
     * @return int
     * @throws RecordNotFoundException
     */
    public function getCountVisits(array $where = [])
    : int {
        $queryBuilder = $this->connection->createQueryBuilder()
            ->select('COALESCE(SUM(count), 0)')
            ->from(self::TABLE);

        if (count($where) > 0) {
            foreach ($where as $column => $value) {
                $queryBuilder->andWhere($column . ' = ' . $queryBuilder->createNamedParameter($value));
            }
        }

        $statement = $queryBuilder->execute();

        $result = $statement->fetch();

        if ($statement->rowCount() === 0) {
            throw new RecordNotFoundException('Record with given where clause not found');
        }

        return $result['COALESCE(SUM(count), 0)'];
    }

    /**
     * @param GeoCacheVisitsEntity $entity
     *
     * @return GeoCacheVisitsEntity
     * @throws RecordAlreadyExistsException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function create(GeoCacheVisitsEntity $entity)
    {
        if (!$entity->isNew()) {
            throw new RecordAlreadyExistsException('The entity does already exist.');
        }

        $databaseArray = $this->getDatabaseArrayFromEntity($entity);

        $this->connection->insert(
            self::TABLE,
            $databaseArray
        );

        $entity->id = (int)$this->connection->lastInsertId();

        return $entity;
    }

    /**
     * @param GeoCacheVisitsEntity $entity
     *
     * @return GeoCacheVisitsEntity
     * @throws RecordNotPersistedException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function update(GeoCacheVisitsEntity $entity)
    {
        if ($entity->isNew()) {
            throw new RecordNotPersistedException('The entity does not exist.');
        }

        $databaseArray = $this->getDatabaseArrayFromEntity($entity);

        $this->connection->update(
            self::TABLE,
            $databaseArray,
            ['id' => $entity->id]
        );

        return $entity;
    }

    /**
     * @param GeoCacheVisitsEntity $entity
     *
     * @return GeoCacheVisitsEntity
     * @throws RecordNotPersistedException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function remove(GeoCacheVisitsEntity $entity)
    {
        if ($entity->isNew()) {
            throw new RecordNotPersistedException('The entity does not exist.');
        }

        $this->connection->delete(
            self::TABLE,
            ['id' => $entity->id]
        );

        $entity->id = null;

        return $entity;
    }

    /**
     * @param GeoCacheVisitsEntity $entity
     *
     * @return array
     */
    public function getDatabaseArrayFromEntity(GeoCacheVisitsEntity $entity)
    {
        return [
            'cache_id' => $entity->cacheId,
            'user_id_ip' => $entity->userIdIP,
            'count' => $entity->count,
            'lastModified' => $entity->lastModified,
        ];
    }

    /**
     * @param array $data
     *
     * @return GeoCacheVisitsEntity
     */
    public function getEntityFromDatabaseArray(array $data)
    {
        $entity = new GeoCacheVisitsEntity();
        $entity->cacheId = (int) $data['cache_id'];
        $entity->userIdIp = (string) $data['user_id_ip'];
        $entity->count = $data['count'];
        $entity->lastModified = new DateTime($data['last_modified']);

        return $entity;
    }
}

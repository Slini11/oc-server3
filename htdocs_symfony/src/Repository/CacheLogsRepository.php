<?php

namespace Oc\Repository;

use DateTime;
use Doctrine\DBAL\Connection;
use Oc\Entity\GeoCacheLogsEntity;
use Oc\Repository\Exception\RecordAlreadyExistsException;
use Oc\Repository\Exception\RecordNotFoundException;
use Oc\Repository\Exception\RecordNotPersistedException;
use Oc\Repository\Exception\RecordsNotFoundException;

class CacheLogsRepository
{
    const TABLE = 'cache_logs';

    /** @var Connection */
    private $connection;

    /**
     * @var LogTypesRepository
     */
    private $logTypesRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var PicturesRepository
     */
    private $picturesRepository;

    /**
     * @var CacheRatingRepository
     */
    private $cacheRatingRepository;

    /**
     * CachesRepository constructor.
     *
     * @param Connection $connection
     * @param LogTypesRepository $logTypesRepository
     * @param UserRepository $userRepository
     * @param PicturesRepository $picturesRepository
     * @param CacheRatingRepository $cacheRatingRepository
     */

    public function __construct(
        Connection $connection,
        LogTypesRepository $logTypesRepository,
        UserRepository $userRepository,
        PicturesRepository $picturesRepository,
        CacheRatingRepository $cacheRatingRepository
    )
    {
        $this->connection = $connection;
        $this->logTypesRepository = $logTypesRepository;
        $this->userRepository = $userRepository;
        $this->picturesRepository = $picturesRepository;
        $this->cacheRatingRepository = $cacheRatingRepository;
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
     * @return GeoCacheLogsEntity
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
     * @throws RecordNotFoundException
     */
    public function fetchBy(array $where = [])
    {
        $queryBuilder = $this->connection->createQueryBuilder()
            ->select('*')
            ->from(self::TABLE)
            ->orderBy('date_created', 'DESC');



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
     * @return array
     * @throws RecordNotFoundException
     */

    public function countLogs(int $cacheId)
    : array {
        $entities = [
            '1' => 0,
            '2' => 0,
            '3' => 0,
            '7' => 0,
            '8' => 0,
            '9' => 0,
            '10' => 0,
            '11' => 0,
            '13' => 0,
            '14' => 0,
        ];

        $queryBuilder = $this->connection->createQueryBuilder()
            ->select('*')
            ->from(self::TABLE)
            ->where('cache_id = :cacheId')
            ->setParameter(':cacheId', $cacheId);

        $statement = $queryBuilder->execute();

        $result = $statement->fetchAll();

        if ($statement->rowCount() === 0) {
            throw new RecordsNotFoundException('No records with given where clause found');
        } else {
            foreach ($result as $item) {
                $entities[(int) $item['type']]++;
            }
        }

        return $entities;
    }

    /**
     * @param array $where
     *
     * @return int
     * @throws RecordNotFoundException
     */
    public function getCountPictures(array $where = [])
    : int {
        $queryBuilder = $this->connection->createQueryBuilder()
            ->select('SUM(picture)')
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

        return $result['SUM(picture)'];
    }


    /**
     * @param GeoCacheLogsEntity $entity
     *
     * @return GeoCacheLogsEntity
     * @throws RecordAlreadyExistsException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function create(GeoCacheLogsEntity $entity)
    {
        if (!$entity->isNew()) {
            throw new RecordAlreadyExistsException('The entity does already exist.');
        }

        $databaseArray = $this->getDatabaseArrayFromEntity($entity);

        $this->connection->insert(
            self::TABLE,
            $databaseArray
        );

        $entity->id = (int) $this->connection->lastInsertId();

        return $entity;
    }

    /**
     * @param GeoCacheLogsEntity $entity
     *
     * @return GeoCacheLogsEntity
     * @throws RecordAlreadyExistsException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function update(GeoCacheLogsEntity $entity)
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
     * @param GeoCacheLogsEntity $entity
     *
     * @return GeoCacheLogsEntity
     * @throws RecordNotPersistedException
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function remove(GeoCacheLogsEntity $entity)
    {
        if ($entity->isNew()) {
            throw new RecordNotPersistedException('The entity does not exist.');
        }

        $this->connection->delete(
            self::TABLE,
            ['id' => $entity->id]
        );

        $entity->cacheId = null;

        return $entity;
    }

    /**
     * @param GeoCacheLogsEntity $entity
     *
     * @return array
     */
    public function getDatabaseArrayFromEntity(GeoCacheLogsEntity $entity)
    {
        return [
            'id' => $entity->id,
            'uuid' => $entity->uuid,
            'node' => $entity->node,
            'date_created' => $entity->dateCreated,
            'entry_last_modified' => $entity->entryLastModified,
            'last_modified' => $entity->lastModified,
            'okapi_syncbase' => $entity->okapiSyncbase,
            'log_last_modified' => $entity->logLastModified,
            'cache_id' => $entity->cacheId,
            'user_id' => $entity->userId,
            'type' => $entity->type,
            'oc_team_comment' => $entity->ocTeamComment,
            'date' => $entity->date,
            'order_date' => $entity->orderDate,
            'needs_maintenance' => $entity->needsMaintenance,
            'listing_outdated' => $entity->listingOutdated,
            'text' => $entity->text,
            'text_html' => $entity->textHtml,
            'text_htmledit' => $entity->textHtmledit,
            'owner_notified' => $entity->ownerNotified,
            'picture' => $entity->picture,
            'logType' => $entity->logType,
            'user' => $entity->user,
            'pictures' => $entity->pictures,
            'ratingCacheLog' => $entity->ratingCacheLog,
        ];
    }

    /**
     * @param array $data
     *
     * @return GeoCacheLogsEntity
     */
    public function getEntityFromDatabaseArray(array $data)
    {
        $entity = new GeoCacheLogsEntity();
        $entity->id = (int) $data['id'];
        $entity->uuid = (string) $data['uuid'];
        $entity->node = (int) $data['node'];
        $entity->dateCreated = new DateTime($data['date_created']);
        $entity->entryLastModified = new DateTime($data['entry_last_modified']);
        $entity->lastModified = new DateTime($data['last_modified']);
        $entity->okapiSyncbase = (string) $data['okapi_syncbase'];
        $entity->logLastModified = new DateTime($data['log_last_modified']);
        $entity->cacheId = (int) $data['cache_id'];
        $entity->userId = (int) $data['user_id'];
        $entity->type = (int) $data['type'];
        $entity->ocTeamComment = (int) $data['oc_team_comment'];
        $entity->date = new DateTime($data['date']);
        $entity->orderDate = new DateTime($data['order_date']);
        $entity->needsMaintenance = (int) $data['needs_maintenance'];
        $entity->listingOutdated = (int) $data['listing_outdated'];
        $entity->text = (string) $data['text'];
        $entity->textHtml = (int) $data['text_html'];
        $entity->textHtmledit = (int) $data['text_htmledit'];
        $entity->ownerNotified = (int) $data['owner_notified'];
        $entity->picture = $data['picture'];
        $entity->logType = $this->logTypesRepository->fetchOneBy(['id' => $entity->type]);
        $entity->user = $this->userRepository->fetchOneById($entity->userId);
        $entity->pictures= $this->picturesRepository->fetchBy(['object_id' => $entity->id, 'object_type' => 1]);
        $entity->ratingCacheLog = $this->cacheRatingRepository->getRatingUserCache(['cache_id'=> $entity->cacheId, 'user_id'=> $entity->userId, ]);


        return $entity;
    }
}

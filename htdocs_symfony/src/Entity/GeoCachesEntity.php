<?php

namespace Oc\Entity;

use DateTime;
use Oc\Repository\AbstractEntity;

/**
 * Class GeoCachesEntity
 *
 * @package Oc\Entity
 */
class GeoCachesEntity extends AbstractEntity
{
    /** @var int */
    public $cacheId;

    /** @var string */
    public $uuid;

    /** @var int */
    public $node;

    /** @var DateTime */
    public $dateCreated;

    /** @var int */
    public $isPublishdate;

    /** @var DateTime */
    public $lastModified;

    /** @var string */
    public $okapiSyncbase;

    /** @var DateTime */
    public $listingLastModified;

    /** @var DateTime */
    public $metaLastModified;

    /** @var int */
    public $userId;

    /** @var string */
    public $name;

    /** @var float */
    public $longitude;

    /** @var float */
    public $latitude;

    /** @var int */
    public $type;

    /** @var int */
    public $status;

    /** @var string */
    public $country;

    /** @var DateTime */
    public $dateHidden;

    /** @var int */
    public $size;

    /** @var int */
    public $difficulty;

    /** @var int */
    public $terrain;

    /** @var string */
    public $logpw;

    /** @var float */
    public $searchTime;

    /** @var float */
    public $wayLength;

    /** @var string */
    public $wpGc;

    /** @var string */
    public $wpGcMaintained;

    /** @var string */
    public $wpNc;

    /** @var string */
    public $wpOc;

    /** @var string */
    public $descLanguages;

    /** @var string */
    public $defaultDesclang;

    /** @var DateTime */
    public $dateActivate;

    /** @var int */
    public $needNpaRecalc;

    /** @var int */
    public $showCachelists;

    /** @var int */
    public $protectOldCoords;

    /** @var int */
    public $needsMaintenance;

    /** @var int */
    public $listingOutdated;

    /** @var DateTime */
    public $flagsLastModified;

    /** @var UserEntity */
    public $user;

    /** @var GeoCacheSizeEntity */
    public $cacheSize;

    /** @var GeoCacheStatusEntity */
    public $cacheStatus;

    /** @var GeoCacheTypeEntity */
    public $cacheType;

    /** @var GeoCacheRatingEntity */

    public $cacheRating;

    /** @var GeoCacheIgnoreEntity */

    public $cacheIgnore;

    /** @var GeoCacheWatchesEntity */

    public $cacheWatches;

    /** @var GeoCacheVisitsEntity */

    public $cacheVisits;

    /** @var LogTypesEntity */
    public $logTypes;

    /** @var int */
    public $ratingCount;

    /** @var int */
    public $ignoreCount;

    /** @var int */
    public $watchesCount;

    /** @var int */
    public $visitsCount;

    /** @var array */
    public $cacheLogs;

    /** @var int */
    public $logsCount;

    /** @var int */
    public $pictureCount;


    /**
     * @return bool
     */
    public function isNew()
    : bool
    {
        return $this->cacheId === null;
    }

    /**
     * @return bool
     */
    public function isActiveAndFindable()
    : bool
    {
        if ($this->status == 1) {
            return true;
        } else {
            return false;
        }
    }
}

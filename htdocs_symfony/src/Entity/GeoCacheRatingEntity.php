<?php

namespace Oc\Entity;

use DateTime;
use Oc\Repository\AbstractEntity;

class GeoCacheRatingEntity extends AbstractEntity
{
    /** @var int */
    public $cacheId;

    /** @var int */
    public $userId;

    /** @var DateTime */
    public $ratingDate;

    /**
     * @return bool
     */
    public function isNew() : bool
    {
        return $this->cacheId === null;
    }
}

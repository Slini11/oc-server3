<?php

namespace Oc\Entity;

use Oc\Repository\AbstractEntity;

class GeoCacheWatchesEntity extends AbstractEntity
{
    /** @var int */
    public $cacheId;

    /** @var int */
    public $userId;

    /**
     * @return bool
     */
    public function isNew() : bool
    {
        return $this->cacheId === null;
    }
}

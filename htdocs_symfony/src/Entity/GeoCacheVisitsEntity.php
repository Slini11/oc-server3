<?php

namespace Oc\Entity;

use DateTime;
use Oc\Repository\AbstractEntity;

class GeoCacheVisitsEntity extends AbstractEntity
{
    /** @var int */
    public $cacheId;

    /** @var int */
    public $userIdIP;

    /** @var int */
    public $count;

    /** @var DateTime */
    public $lastModified;

    /**
     * @return bool
     */
    public function isNew() : bool
    {
        return $this->cacheId === null;
    }
}

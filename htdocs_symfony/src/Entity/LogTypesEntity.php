<?php

namespace Oc\Entity;

use DateTime;
use Oc\Repository\AbstractEntity;

class LogTypesEntity extends AbstractEntity
{
    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var int */
    public $transId;

    /** @var string */
    public $permission;

    /** @var int */
    public $cacheStatus;

    /** @var string */
    public $de;

    /** @var string */
    public $en;

    /** @var string */
    public $iconSmall;

    /** @var int */
    public $allowRating;

    /** @var int */
    public $requirePassword;

    /** @var int */
    public $maintenanceLogs;

    /**
     * @return bool
     */
    public function isNew() : bool
    {
        return $this->id === null;
    }
}

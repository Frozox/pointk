<?php

namespace Doctrine\DBAL\Driver\SQLSrv;

/**
 * Last Id Data Container.
 */
class LastInsertId
{
    /** @var int */
    private $id;

    /**
     * @param int $id
<<<<<<< HEAD
=======
     *
     * @return void
>>>>>>> ThomasN
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

<?php

namespace Admin\Model;

use Core\Model\BaseModel;

class LogModel extends BaseModel
{
    public function __construct()
    {
        $this->setEntity('Admin\Entity\Log');
    }
}

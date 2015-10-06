<?php

namespace Admin\Model;

use Core\Model\BaseModel;

class NoticiaModel extends BaseModel
{
    public function __construct()
    {
        $this->setEntity('Admin\Entity\Noticia');
    }
}

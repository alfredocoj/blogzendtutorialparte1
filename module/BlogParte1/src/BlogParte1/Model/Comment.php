<?php

namespace BlogParte1\Model;
use Core\Model\BaseModel;

class CommentModel extends BaseModel
{

	//Definimos nossa entity na model.
	public function __construct()
	{
		$this->setEntity('Admin\Entity\Comment');
	}

}

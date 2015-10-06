<?php

namespace Admin\Controller;
use Core\Controller\CRUDController;
use Core\Util\MenuBarButton;
use Core\Util\Constantes;
use Admin\Form\PostForm;
use Admin\Entity\Post;
use Zend\View\Model\ViewModel;

class PostsController extends CRUDController
{
	public function __construct()
	{
		$form       = new PostForm();
		$entity     = new Post();
		$model      = Constantes::MODEL_POST;
		$actionBase = '/admin/posts';
		$label      = 'Posts';
		parent::__construct($entity, $model, $form, $actionBase, $label);
	}
}

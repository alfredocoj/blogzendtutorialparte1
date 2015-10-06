<?php

namespace Core\View\Helper;
use Zend\View\Helper\AbstractHelper;

class FlashMessages extends AbstractHelper
{

    protected $flashMessenger;

    public function setFlashMessenger($flashMessenger)
    {
        $this->flashMessenger = $flashMessenger ;
    }
    public function __invoke()
    {
        $namespaces = array(
            'danger' ,'success', 'info','warning'
        );
        // messages as string
        $messageString = '';
        foreach ($namespaces as $ns) {

            $this->flashMessenger->setNamespace( $ns );

            $messages = array_merge(
                $this->flashMessenger->getMessages(),
                $this->flashMessenger->getCurrentMessages()
            );

            if ( ! $messages ) continue;

            $messageString .= "<div class='alert alert-$ns fade in'>";
            $messageString .= "<a href='#' class='close' data-dismiss='alert' aria-label='close' title='close'>×</a>";
            $messageString .= implode( '<br />', $messages );
            $messageString .= '</div>';
        }

        return $messageString ;
    }
}

<?php

namespace Core\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\I18n\Translator\Translator;

class SubMenu extends AbstractHelper
{

    protected $level = 0;
    protected $class;
    protected $header;
    protected $translator;
    protected $textdomain;

    public function __invoke()
    {
        return $this;
    }

    public function setLevel($level)
    {
        $this->level = (int) $level;

        return $this;
    }

    public function setClass($class)
    {
        $this->class = (string) $class;

        return $this;
    }

    public function setHeader($header)
    {
        $this->header = (string) $header;

        return $this;
    }

    public function setTranslator(Translator $translator, $textdomain = 'default')
    {
        $this->translator = $translator;
        $this->textdomain = $textdomain;

        return $this;
    }

    public function __toString()
    {
        $view = $this->getView();
        $menu = $view->navigation('navigation')->menu();
        echo 'oi';
        print_r($menu);
        exit;

        $current = $menu->getContainer();
        $flag    = $menu->getRenderInvisible();
        $active  = $menu->setRenderInvisible(true)->findActive($current);
        $menu->setRenderInvisible($flag);

        if (!$active) {
            return '';
        }

        $container = $active['page'];
        $depth     = $active['depth'];

        while ($this->level !== $depth) {
            $container = $container->getParent();
            $depth--;
        }

        // Set container explicitly to visible
        $flag = $container->isVisible();
        $container->setVisible(true);

        // Inject translator
        $enabled    = $menu->isTranslatorEnabled();
        $translator = $menu->getTranslator();
        $textdomain = $menu->getTranslatorTextDomain();
        if ($this->translator) {
            $menu->setTranslator($this->translator, $this->textdomain);
            $menu->setTranslatorEnabled(true);
        }

        $html = $menu->setContainer($container)
                     ->setUlClass('')
                     ->setOnlyActiveBranch(false)
                     ->setMinDepth(null)
                     ->setMaxDepth(null)
                     ->render();

        // Reset the visibility flag
        $container->setVisible($flag);
        // Reset the container
        $menu->setContainer($current);
        // Reset translator
        $menu->setTranslatorEnabled($enabled);
        $menu->setTranslator($translator, $textdomain);

        if (!strlen($html)) {
            return '';
        }

        $label = $this->header ?: $container->getLabel();
        if ($this->translator) {
            $label = $this->translator->translate($label, $this->textdomain);
        }

        return sprintf('<ul%s><li%s><a href="%s">%s</a>%s</li></ul>',
                (null !== $this->class) ? ' class="' . $this->class . '"' : null,
                ($container->isActive())? ' class="active"' : null,
                $container->getHref(),
                $label,
                $html);
    }
}

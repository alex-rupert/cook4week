<?php

namespace AdminBundle\Twig;

class GetClassNameExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getClassName', array($this, 'getExecute')),
        );
    }

    public function getExecute($object)
    {
        return (new \ReflectionClass($object))->getShortName();
    }
}

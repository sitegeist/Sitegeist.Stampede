<?php
namespace Sitegeist\Hieroglyph\Controller;

use Neos\Error\Messages as Error;
use Neos\Flow\Mvc\Controller\ActionController;
use Sitegeist\Hieroglyph\Domain\IconSetRepository;

class SvgController extends ActionController
{

    /**
     * @param string $iconSet
     * @return string
     */
    public function spriteAction(string $iconSet)
    {

        return "Foobar";
    }
}

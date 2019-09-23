<?php
namespace Sitegeist\Hieroglyph\Controller;

use Neos\Flow\Annotations as Flow;
use Neos\Error\Messages as Error;
use Neos\Flow\Mvc\Controller\ActionController;
use Sitegeist\Hieroglyph\Domain\IconSetRepository;

class SvgController extends ActionController
{
    /**
     * @var IconSetRepository
     * @Flow\Inject
     */
    protected $iconSetRepository;

    /**
     * @param string $iconSet
     * @return string
     */
    public function spriteAction(string $iconSet)
    {
        $iconSet = $this->iconSetRepository->findOneByName($iconSet);
        $domDocument = new \DOMDocument('1.0', 'UTF-8');

        // ignore parsing errors
        $useInternalErrorsBackup = libxml_use_internal_errors(true);

        $domDocument->loadXML('<svg style="position:absolute" ></svg>');
        $svgTag = $domDocument->documentElement;
        foreach ($iconSet->findAll() as $icon) {
            $iconSvg = new \DOMDocument('1.0', 'UTF-8');
            $iconSvg->load($icon->getPath());
            $iconRootTag = $iconSvg->documentElement;
            $symbol = $domDocument->createElement('symbol');
            $symbol->setAttribute('id', $icon->getName());
            $symbol->setAttribute('xmlns', 'http://www.w3.org/2000/svg');

            // copy child nodes
            foreach($iconRootTag->childNodes as $childNode) {
                /**
                 * @var \DOMNode $childNode
                 */
                if (in_array($childNode->localName, ['metadata'])) {
                    continue;
                }
                $importedNode = $domDocument->importNode($childNode, true);
                $symbol->appendChild($importedNode);
            }
            // copy attributes
            foreach($iconRootTag->attributes as $name => $attribute) {
                /**
                 * @var \DOMNode $attribute
                 */
                if (in_array($name, ['id', 'xmlns'])) {
                    continue;
                }
                $symbol->setAttribute($name, $attribute->nodeValue);
            }

            $svgTag->appendChild($symbol);
        }

        // resore lib xml error handling
        libxml_use_internal_errors($useInternalErrorsBackup);

        $this->response->setHeader('Content-Type', 'image/svg+xml');
        return $domDocument->saveXML();;
    }
}

<?php
namespace Sitegeist\Stampede\Controller;

use Neos\Flow\Annotations as Flow;
use Neos\Error\Messages as Error;
use Neos\Flow\Mvc\Controller\ActionController;
use Sitegeist\Stampede\Domain\IconCollectionRepository;
use Neos\Cache\Frontend\VariableFrontend;

class SvgController extends ActionController
{
    /**
     * @var IconCollectionRepository
     * @Flow\Inject
     */
    protected $iconCollectionRepository;

    /**
     * @var VariableFrontend
     * @Flow\Inject
     */
    protected $svgSpriteCache;

    /**
     * @var array
     * @Flow\InjectConfiguration()
     */
    protected $configuration;

    /**
     * @param string $collection
     * @return string
     */
    public function spriteAction(string $collection)
    {
        if ($this->configuration['enableCache'] && $this->svgSpriteCache->has($collection)) {
            $result = $this->svgSpriteCache->get($collection);
            if ($result) {
                $this->response->setContentType('image/svg+xml');
                return $result;
            } else {
                $this->response->setStatusCode('404');
                return "Not found";
            }
        }

        $result = $this->generateSprite($collection);

        if ($this->configuration['enableCache']) {
            $this->svgSpriteCache->set($collection, $result);
        }

        if ($result) {
            $this->response->setContentType('image/svg+xml');
            return $result;
        } else {
            $this->response->setStatusCode('404');
            return "Not found";
        }
    }

    /**
     * @param string $iconCollection
     * @return string
     */
    protected function generateSprite (string $collection): ?string
    {
        $iconCollection = $this->iconCollectionRepository->findOneByIdentifier($collection);
        if (!$iconCollection) {
            return null;
        }

        $domDocument = new \DOMDocument('1.0', 'UTF-8');

        // ignore parsing errors
        $useInternalErrorsBackup = libxml_use_internal_errors(true);

        $domDocument->loadXML('<svg style="fill:black;" x="0px" y="0px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 500 500"></svg>');

        $svgTag = $domDocument->documentElement;
        $index = 0;
        $columns = 5;

        foreach ($iconCollection->findAll() as $icon) {
            $iconSvg = new \DOMDocument('1.0', 'UTF-8');
            $iconSvg->loadXML($icon->getSvg());
            $iconRootTag = $iconSvg->documentElement;
            $symbol = $domDocument->createElement('symbol');
            $symbol->setAttribute('id', $icon->getIdentifier());
            $symbol->setAttribute('xmlns', 'http://www.w3.org/2000/svg');

            // copy svg child nodes to symbol
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

            // copy svg attributes to symbol
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

            $use = $domDocument->createElement('use');
            $use->setAttribute('href', '#' . $icon->getIdentifier());
            $use->setAttribute('x', (10 + ($index % $columns) * 100)) ;
            $use->setAttribute('y', (10 + floor ($index / $columns) * 100));
            $use->setAttribute('width', 80);
            $svgTag->appendChild($use);

            $index ++;
        }

        // resore lib xml error handling
        libxml_use_internal_errors($useInternalErrorsBackup);

        return $domDocument->saveXML();
    }
}

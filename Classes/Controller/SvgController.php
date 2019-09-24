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
                $this->response->setHeader('Content-Type', 'image/svg+xml');
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
            $this->response->setHeader('Content-Type', 'image/svg+xml');
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
        $iconCollection = $this->iconCollectionRepository->findOneByName($collection);
        if (!$iconCollection) {
            return null;
        }

        $domDocument = new \DOMDocument('1.0', 'UTF-8');

        // ignore parsing errors
        $useInternalErrorsBackup = libxml_use_internal_errors(true);

        $domDocument->loadXML('<svg style="position:absolute" ></svg>');
        $svgTag = $domDocument->documentElement;
        foreach ($iconCollection->findAll() as $icon) {
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

        return $domDocument->saveXML();
    }
}

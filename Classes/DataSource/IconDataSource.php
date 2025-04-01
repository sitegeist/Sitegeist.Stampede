<?php

declare(strict_types=1);

namespace Sitegeist\Stampede\DataSource;

use Neos\ContentRepository\Core\Projection\ContentGraph\Node;
use Neos\Flow\Annotations as Flow;
use Neos\Neos\Service\DataSource\AbstractDataSource;
use Sitegeist\Stampede\Domain\IconCollection;
use Sitegeist\Stampede\Domain\IconCollectionRepository;

class IconDataSource extends AbstractDataSource
{
    /**
     * @var string
     */
    protected static $identifier = 'sitegeist-stampede-icons';

    /**
     * @var IconCollectionRepository
     * @Flow\Inject
     */
    protected $iconCollectionRepository;

    /**
     * Get data
     *
     * @param Node $node The node that is currently edited (optional)
     * @param array<string|int,string> $arguments Additional arguments (key / value)
     * @return array<string|int,array<string,string>> JSON serializable data
     */
    public function getData(Node $node = null, array $arguments = []): array
    {
        $result = [];

        if (array_key_exists('collections', $arguments) && !empty($arguments['collections'])) {
            /**
             * @var IconCollection[]
             */
            $iconCollections = [];
            foreach ($arguments['collections'] as $iconCollection) {
                $collection = $this->iconCollectionRepository->findOneByIdentifier($iconCollection);
                if ($collection) {
                    $iconCollections[] = $collection;
                }
            }
        } else {
            $iconCollections = $this->iconCollectionRepository->findAll();
        }

        foreach ($iconCollections as $iconCollection) {
            foreach ($iconCollection->findAll() as $icon) {
                $result[] = [
                    'group' => $iconCollection->getLabel(),
                    'value' => $iconCollection->getIdentifier() . ':' . $icon->getIdentifier(),
                    'icon' => $iconCollection->getIdentifier() . ':' . $icon->getIdentifier(),
                    'label' => $icon->getLabel(),
                    'preview' => 'data:image/svg+xml;base64,' . base64_encode($icon->getSvg())
                ];
            }
        }

        return $result;
    }
}

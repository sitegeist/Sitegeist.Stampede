<?php
namespace Sitegeist\Stampede\DataSource;

use Neos\Flow\Annotations as Flow;
use Neos\Neos\Service\DataSource\AbstractDataSource;
use Neos\ContentRepository\Domain\Model\NodeInterface;
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
     * @param NodeInterface $node The node that is currently edited (optional)
     * @param array $arguments Additional arguments (key / value)
     * @return array JSON serializable data
     */
    public function getData(NodeInterface $node = null, array $arguments)
    {
        $result = [];

        if (array_key_exists('collections', $arguments) && !empty($arguments['collections'])) {
            $iconCollections = [];
            foreach ($arguments['collections'] as $iconCollection) {
                $collection = $this->iconCollectionRepository->findOneByName($iconCollection);
                if ($collection) {
                    $iconCollections[] = $collection;
                }
            }
        } else {
            $iconCollections = $this->iconCollectionRepository->findAll();
        }

        foreach ($iconCollections as $iconCollection) {
            foreach ($iconCollection->findAll() as $icon) {
                $result[] = ['value' => $iconCollection->getName() . ':' . $icon->getName(), 'label' => $icon->getName() . ' (' . $iconCollection->getName() . ')'];
            }
        }

        return $result;
    }
}

<?php
namespace Sitegeist\Stampede\Domain;

use Neos\Flow\Annotations as Flow;

/**
 * Class IconCollectionRepository
 * @package Sitegeist\Stampede\Domain
 * @Flow\Scope("singleton")
 */
class IconCollectionRepository
{
    /**
     * @var array
     * @Flow\InjectConfiguration()
     */
    protected $configuration;

    /**
     * @var IconCollection[]
     */
    protected $iconCollections = [];

    /**
     * IconCollectionRepository constructor.
     */
    public function initializeObject()
    {
        foreach ($this->configuration['collections'] as $identifier => $collection) {
            $this->iconCollections[$identifier] = new IconCollection($identifier, $collection['label'], $collection['path']);
        }
    }

    /**
     * @return IconCollection[]
     */
    public function findAll(): array
    {
        return $this->iconCollections;
    }

    /**
     * @return IconCollection|null
     */
    public function findOneByIdentifier($identifier): ?IconCollection
    {
        return $this->iconCollections[$identifier] ?? null;
    }
}

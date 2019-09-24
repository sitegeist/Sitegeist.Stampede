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
        foreach ($this->configuration['collections'] as $name => $path) {
            $this->iconCollections[$name] = new IconCollection($name, $path);
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
    public function findOneByName($name): ?IconCollection
    {
        return $this->iconCollections[$name] ?? null;
    }
}

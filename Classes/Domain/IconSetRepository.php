<?php
namespace Sitegeist\Hieroglyph\Domain;

use Neos\Flow\Annotations as Flow;

/**
 * Class IconSetRepository
 * @package Sitegeist\Hieroglyph\Domain
 * @Flow\Scope("singleton")
 */
class IconSetRepository
{
    /**
     * @var array
     * @Flow\InjectConfiguration()
     */
    protected $configuration;

    /**
     * @var IconSet[]
     */
    protected $iconSets = [];

    /**
     * IconSetRepository constructor.
     */
    public function initializeObject()
    {
        foreach ($this->configuration['iconSets'] as $name => $path) {
            $this->iconSets[$name] = new IconSet($name, $path);
        }
    }

    /**
     * @return IconSet[]
     */
    public function findAll(): array
    {
        return $this->iconSets;
    }

    /**
     * @return IconSet|null
     */
    public function findOneByName($name): ?IconSet
    {
        return $this->iconSets[$name] ?? null;
    }
}

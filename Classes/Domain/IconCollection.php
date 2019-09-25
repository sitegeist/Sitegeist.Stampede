<?php
namespace Sitegeist\Stampede\Domain;

use Neos\Flow\Annotations as Flow;
use Neos\Utility\Files;

class IconCollection
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var Icon[]
     */
    protected $icons = [];

    /**
     * IconCollection constructor.
     * @param string $name
     * @param array $collectionConfiguration
     */
    public function __construct(string $identifier, array $collectionConfiguration)
    {
        $this->identifier = $identifier;
        $this->label = $collectionConfiguration['label'] ?? $identifier;

        if (array_key_exists('path', $collectionConfiguration)) {
            $path = $collectionConfiguration['path'] ;
            $svgFiles = Files::readDirectoryRecursively($path, 'svg');
            foreach ($svgFiles as $svgFile) {
                $name = substr($svgFile, strlen($path) + 1, strlen($svgFile) - strlen($path) - 5);
                $label = $name;
                $this->icons[$name] = new Icon($this->identifier, $name, $label, $svgFile);
            }
        } elseif (array_key_exists('items', $collectionConfiguration) && is_array($collectionConfiguration['items'])) {
            foreach ($collectionConfiguration['items'] as $name => $itemConfiguration) {
                $label = $itemConfiguration['label'] ?? $name;
                if (array_key_exists('path', $itemConfiguration) && file_exists( $itemConfiguration['path'])) {
                    $this->icons[$name] = new Icon($this->identifier, $name, $label, $itemConfiguration['path']);
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return Icon[]
     */
    public function getIcons(): array
    {
        return $this->icons;
    }

    /**
     * @return Icon[]
     */
    public function findAll(): array
    {
        return $this->icons;
    }
}

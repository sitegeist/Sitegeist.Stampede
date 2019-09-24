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
     * @var string
     */
    protected $path;

    /**
     * @var Icon[]
     */
    protected $icons = [];

    /**
     * IconCollection constructor.
     * @param string $name
     * @param string $path
     */
    public function __construct(string $identifier, string $label, string $path)
    {
        $this->identifier = $identifier;
        $this->label = $label;
        $this->path = $path;
        $svgFiles = Files::readDirectoryRecursively($path, 'svg');
        foreach ($svgFiles as $svgFile) {
            $name = substr($svgFile, strlen($path) + 1, strlen($svgFile) - strlen($path) - 5);
            $label = $name;
            $this->icons[$name] = new Icon($this->identifier, $name, $label, $svgFile);
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
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
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

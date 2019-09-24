<?php
namespace Sitegeist\Stampede\Domain;

use Neos\Flow\Annotations as Flow;
use Neos\Utility\Files;

class IconSet
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var Icon[]
     */
    protected $icons = [];

    /**
     * IconSet constructor.
     * @param string $name
     * @param string $path
     */
    public function __construct(string $name, string $path)
    {
        $this->name = $name;
        $this->path = $path;
        $svgFiles = Files::readDirectoryRecursively($path, 'svg');
        foreach ($svgFiles as $svgFile) {
            $name = substr($svgFile, strlen($path) + 1, strlen($svgFile) - strlen($path) - 5);
            $this->icons[$name] = new Icon($name, $svgFile);
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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

    /**
     * @param string $name
     * @return Icon|null
     */
    public function findOneByName(string $name): ?Icon
    {
        return $this->icons[$name] ?? null;
    }
}

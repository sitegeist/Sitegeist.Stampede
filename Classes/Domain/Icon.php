<?php
namespace Sitegeist\Stampede\Domain;

use Neos\Flow\Annotations as Flow;

class Icon {

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
     * IconCollection constructor.
     * @param string $name
     * @param string $path
     */
    public function __construct(string $identifier, string $label, string $path)
    {
        $this->identifier = $identifier;
        $this->label = $label;
        $this->path = $path;
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
     * @return string
     */
    public function getSvg(): string
    {
        return file_get_contents($this->path);
    }
}

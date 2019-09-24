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
    protected $name;


    /**
     * @var string
     */
    protected $collection;

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
    public function __construct(string $collection, string $name, string $label, string $path)
    {
        $this->identifier = $collection . ':' . $name;
        $this->collection = $collection;
        $this->name = $name;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCollection(): string
    {
        return $this->collection;
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
}

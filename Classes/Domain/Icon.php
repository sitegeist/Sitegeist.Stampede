<?php
namespace Sitegeist\Stampede\Domain;

use Neos\Flow\Annotations as Flow;

class Icon {

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $path;

    /**
     * IconCollection constructor.
     * @param string $name
     * @param string $path
     */
    public function __construct(string $name, string $path)
    {
        $this->name = $name;
        $this->path = $path;
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
}

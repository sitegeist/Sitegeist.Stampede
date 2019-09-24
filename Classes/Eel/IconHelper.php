<?php
namespace Sitegeist\Stampede\Eel;

use Neos\Flow\Annotations as Flow;
use Neos\Eel\ProtectedContextAwareInterface;
use Sitegeist\Stampede\Domain\IconCollection;
use Sitegeist\Stampede\Domain\IconCollectionRepository;

class IconHelper implements ProtectedContextAwareInterface
{
    /**
     * @var IconCollectionRepository
     * @Flow\Inject
     */
    protected $iconCollectionRepository;

    /**
     * @return IconCollection[]
     */
    public function allCollections(): array
    {
        return $this->iconCollectionRepository->findAll();
    }

    /**
     * @return IconCollection|null
     */
    public function collection(string $name): ?IconCollection
    {
        return $this->iconCollectionRepository->findOneByName($name);
    }

    public function allowsCallOfMethod($methodName)
    {
        return true;
    }
}

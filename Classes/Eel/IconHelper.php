<?php
namespace Sitegeist\Stampede\Eel;

use Neos\Flow\Annotations as Flow;
use Neos\Eel\ProtectedContextAwareInterface;
use Sitegeist\Stampede\Domain\Icon;
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
     * @param string $collection
     * @param string $name
     * @return Icon|null
     */
    public function icon(string $collection, string $name): ?Icon
    {
        $collection = $this->collection($collection);
        if ($collection) {
            return $collection->findOneByIdentifier($name);
        }
        return null;
    }

    /**
     * @param string $name
     * @return IconCollection|null
     */
    public function collection(string $name): ?IconCollection
    {
        return $this->iconCollectionRepository->findOneByIdentifier($name);
    }

    /**
     * @param string $methodName
     * @return bool
     */
    public function allowsCallOfMethod($methodName)
    {
        return true;
    }
}

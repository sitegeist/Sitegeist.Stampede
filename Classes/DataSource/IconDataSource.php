<?php
namespace Sitegeist\Hieroglyph\DataSource;

use Neos\Flow\Annotations as Flow;
use Neos\Neos\Service\DataSource\AbstractDataSource;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Utility\Files;
use Sitegeist\SitegeistDe\Eel\IconHelper;
use Sitegeist\Hieroglyph\Domain\IconSetRepository;

class IconDataSource extends AbstractDataSource
{
    /**
     * @var string
     */
    protected static $identifier = 'sitegeist-hieroglyph-icons';

    /**
     * @var IconSetRepository
     * @Flow\Inject
     */
    protected $iconSetRepository;

    /**
     * Get data
     *
     * @param NodeInterface $node The node that is currently edited (optional)
     * @param array $arguments Additional arguments (key / value)
     * @return array JSON serializable data
     */
    public function getData(NodeInterface $node = null, array $arguments)
    {
        $result = [];

        if (array_key_exists('iconSets', $arguments) && !empty($arguments['iconSets'])) {
            $iconSets = [];
            foreach ($arguments['iconSets'] as $iconSet) {
                $iconSets[] = $this->iconSetRepository->findOneByName($iconSet);
            }
        } else {
            $iconSets = $this->iconSetRepository->findAll();
        }

        foreach ($iconSets as $iconSet) {
            foreach ($iconSet->findAll() as $icon) {
                $result[] = ['value' => $iconSet->getName() . ':' . $icon->getName(), 'label' => $icon->getName() . ' (' . $iconSet->getName() . ')'];
            }
        }

        return $result;
    }
}

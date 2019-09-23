<?php
namespace Sitegeist\Hieroglyph\DataSource;

use Neos\Flow\Annotations as Flow;
use Neos\Neos\Service\DataSource\AbstractDataSource;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Utility\Files;
use Sitegeist\SitegeistDe\Eel\IconHelper;

class IconDataSource extends AbstractDataSource
{
    /**
     * @var string
     */
    protected static $identifier = 'sitegeist-hieroglyph-icons';



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

//        // find all svg files and extract the names
//        $iconNames = $this->iconHelper->getAvailableNames();
//        foreach ($iconNames as $iconName) {
//            // ignore files that start with underscore
//            if ($iconName[0] == '_') {
//                continue;
//            }
//            $result[] = ['value' => $iconName, 'label' => $iconName];
//        }

        return $result;
    }
}

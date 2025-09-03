<?php
declare(strict_types=1);

namespace Sitegeist\Stampede\Command;

use Neos\Flow\Cli\CommandController;
use Sitegeist\Stampede\Domain\IconCollectionRepository;
use Neos\Flow\Annotations as Flow;

class IconCollectionCommandController extends CommandController {

    #[Flow\Inject]
    public IconCollectionRepository $iconCollectionRepository;

    /**
     * List all iconCollections
     */
    public function listCommand(): void
    {
        $collections = $this->iconCollectionRepository->findAll();
        $headers = ['id', 'title', 'required'];
        $rows = [];
        foreach ($collections as $collection) {
            $rows[] = [$collection->getIdentifier(), $collection->getLabel(),  implode(',', $collection->getRequiredIconIdentifiers())];
        }
        $this->output->outputTable($rows, $headers);
    }

    /**
     * Verify that all collections have the required icons as specified
     */
    public function verifyAllCommand(): void
    {
        $success = true;
        $collections = $this->iconCollectionRepository->findAll();
        foreach ($collections as $collection) {
            $missing = $collection->findMissingIconIdentifiers();
            if (!empty($missing)) {
                $this->outputLine('- collection %s misses icons: %s', [$collection->getIdentifier(), implode(',', $missing)]);
                $success = false;
            }
        }
        if (!$success) {
            $this->quit(1);
        }
    }
}

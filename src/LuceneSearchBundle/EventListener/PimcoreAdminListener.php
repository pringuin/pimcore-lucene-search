<?php
namespace LuceneSearchBundle\EventListener;

use Pimcore\Event\BundleManager\PathsEvent;

class PimcoreAdminListener
{
    public function addCSSFiles(PathsEvent $event): void
    {
        $event->setPaths(
            array_merge(
                $event->getPaths(),
                [
                    '/bundles/lucenesearch/css/admin.css'
                ]
            )
        );
    }

    public function addJSFiles(PathsEvent $event): void
    {
        $event->setPaths(
            array_merge(
                $event->getPaths(),
                [
                    '/bundles/lucenesearch/js/backend/startup.js',
                    '/bundles/lucenesearch/js/backend/settings.js'
                ]
            )
        );
    }
}

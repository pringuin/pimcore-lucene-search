<?php

namespace LuceneSearchBundle\EventListener;

use LuceneSearchBundle\Tool\CrawlerState;
use Pimcore\Http\Request\Resolver\DocumentResolver;
use Pimcore\Model\Document\Page;
use Pimcore\Twig\Extension\Templating\HeadMeta;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class DocumentMetaDataListener
{
    /**
     * @var CrawlerState
     */
    protected $crawlerState;

    /**
     * @var DocumentResolver
     */
    protected $documentResolver;

    /**
     * @var HeadMeta
     */
    protected $headMeta;

    /**
     * DocumentMetaDataListener constructor.
     *
     * @param CrawlerState     $crawlerState
     * @param DocumentResolver $documentResolver
     * @param HeadMeta         $headMeta
     */
    public function __construct(CrawlerState $crawlerState, DocumentResolver $documentResolver, HeadMeta $headMeta)
    {
        $this->crawlerState = $crawlerState;
        $this->documentResolver = $documentResolver;
        $this->headMeta = $headMeta;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$this->crawlerState->isLuceneSearchCrawler()) {
            return;
        }

        $request = $event->getRequest();

        if (!$event->isMainRequest()) {
            return;
        }

        $document = $this->documentResolver->getDocument($request);

        if ($document instanceof Page) {
            $this->headMeta->addRaw('<meta name="lucene-search:documentId" content="' . $document->getId() . '" />');
        }
    }
}

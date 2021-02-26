<?php

namespace Demo5\Presentation\Modules\BannerMain;

use Demo5\Application\Content\ContentService;

/**
 * Class BannerMain
 * @package Demo5\Presentation\Modules\BannerMain
 */
class BannerMain extends AbstractModule
{
    /**
     * @var BannerMainParams
     */
    protected $params;

    protected $contentService;

    /**
     * BannerMain constructor.
     * @param ContentService $contentService
     */
    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }


    /**
     * @return string
     */
    public function process(): string
    {

        $items = $this->contentService->getBanners(
            BannerCriteria::create()
                ->setLimit($this->params->getLimit())
                ->isRand($this->params->isRand())
        );

        return $this->render([
            'items' => $items
        ]);
    }

}
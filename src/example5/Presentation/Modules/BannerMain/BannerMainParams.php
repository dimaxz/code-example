<?php


namespace Demo5\Presentation\Modules\BannerMain;


class BannerMainParams extends AbstractModuleParams
{

    protected $limit = 5;

    protected $rand = false;

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return bool
     */
    public function isRand(): bool
    {
        return $this->rand;
    }

}
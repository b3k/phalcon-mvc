<?php

namespace App\Library\Controller\Traits;

use App\Library\Asset\Manager;

trait Asset
{

    public function getAssetsManager()
    {
        return $this->getDi()->getShared('assets');
    }

    /**
     * Add javascript file to assets.
     *
     * @param string $file       File path.
     * @param string $collection Collection name.
     *
     * @return void
     */
    public function addJs($file, $collection = Manager::DEFAULT_COLLECTION_JS)
    {
        $this->getAssetsManager()->get($collection)->addJs($file);
    }

    /**
     * Add css file to assets.
     *
     * @param string $file       File path.
     * @param string $collection Collection name.
     *
     * @return void
     */
    public function addCss($file, $collection = Manager::DEFAULT_COLLECTION_CSS)
    {
        $this->getAssetsManager()->get($collection)->addCss($file);
    }

}

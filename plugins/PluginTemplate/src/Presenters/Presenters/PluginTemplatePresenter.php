<?php

namespace Plugins\PluginTemplate\Presenters\Presenters;

use Plugins\PluginTemplate\Presenters\Transformers\PluginTemplateTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PluginTemplatePresenter.
 *
 * @package namespace App\PluginTemplate\Presenters\Presenters;
 */
class PluginTemplatePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new PluginTemplateTransformer();
    }
}

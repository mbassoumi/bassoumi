<?php

namespace Plugins\PluginTemplate\Presenters\Transformers;

use League\Fractal\TransformerAbstract;
use Plugins\PluginTemplate\Models\PluginTemplate;

/**
 * Class PluginTemplateTransformer.
 *
 * @package namespace App\PluginTemplate\Presenters\Transformers;
 */
class PluginTemplateTransformer extends TransformerAbstract
{
    /**
     * Transform the PluginTemplate entity.
     *
     * @param \Plugins\PluginTemplate\Models\PluginTemplate $model
     *
     * @return array
     */
    public function transform(PluginTemplate $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

<?php

namespace Plugins\UserManagement\Presenters\Transformers;

use League\Fractal\TransformerAbstract;
use Plugins\UserManagement\Models\User;

/**
 * Class UserTransformer.
 *
 * @package namespace App\User\Presenters\Transformers;
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * Transform the User entity.
     *
     * @param \Plugins\User\Models\User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}

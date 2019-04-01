<?php
/**
 * Created by Bassoumi Generation command.
 * User: Majd Bassoumi
 * Date: 01-04-2019
 * Time: 2:43 PM
 */

namespace Plugins\UserManagement\Presenters\Transformers;

use League\Fractal\TransformerAbstract;
use Plugins\UserManagement\Models\User;

/**
 * Class UserTransformer.
 *
 * @package Plugins\UserManagement\Presenters\Transformers
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * Transform the User entity.
     *
     * @param User $user
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id'         => (int) $user->id,

            /* place your other model properties here */

            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ];
    }
}

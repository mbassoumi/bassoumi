<?php
/**
 * Created by Bassoumi Generation command.
 * User: Majd Bassoumi
 * Date: 01-04-2019
 * Time: 2:43 PM
 */

namespace Plugins\UserManagement\Presenters\Presenters;

use Plugins\UserManagement\Presenters\Transformers\UserTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UserPresenter.
 *
 * @package Plugins\UserManagement\Presenters\Presenters
 */
class UserPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UserTransformer();
    }
}

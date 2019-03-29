<?php

namespace Plugins\PluginTemplate\Repositories\Eloquent;

use Plugins\PluginTemplate\Models\PluginTemplate;
use Plugins\PluginTemplate\Repositories\Contracts\PluginTemplateRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Plugins\PluginTemplate\Validators\PluginTemplateValidator;

/**
 * Class PluginTemplateRepositoryEloquent.
 *
 * @package namespace App\PluginTemplate\Repositories\Eloquent;
 */
class PluginTemplateRepositoryEloquent extends BaseRepository implements PluginTemplateRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PluginTemplate::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PluginTemplateValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

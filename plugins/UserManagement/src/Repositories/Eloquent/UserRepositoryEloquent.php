<?php

namespace Plugins\UserManagement\Repositories\Eloquent;

use Plugins\UserManagement\Models\User;
use Plugins\UserManagement\Repositories\Contracts\UserRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Plugins\UserManagement\Validators\UserValidator;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\User\Repositories\Eloquent;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return UserValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}

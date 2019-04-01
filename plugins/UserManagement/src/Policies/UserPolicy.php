<?php
/**
 * Created by Bassoumi Generation command.
 * User: Majd Bassoumi
 * Date: 01-04-2019
 * Time: 2:43 PM
 */

namespace Plugins\UserManagement\Policies;


use App\User;
use Plugins\UserManagement\Models\User;

class UserPolicy
{


    /**
     * check if users can view the $users
     *
     * @param User $user
     * @param User $user
     * @return boolean
     */
    public function view(User $user, User $user)
    {
        return true;
    }


    /**
     * check if users can edit the $users
     *
     * @param User $user
     * @param User $user
     * @return boolean
     */
    public function edit(User $user, User $user)
    {
        return true;
    }


    /**
     * check if users can update the $users
     *
     * @param User $user
     * @param User $user
     * @return boolean
     */
    public function update(User $user, User $user)
    {
        return true;
    }


    /**
     * check if users can create the $users
     *
     * @param User $user
     * @param User $user
     * @return boolean
     */
    public function create(User $user, User $user)
    {
        return true;
    }


    /**
     * check if users can store the $users
     *
     * @param User $user
     * @param User $user
     * @return boolean
     */
    public function store(User $user, User $user)
    {
        return true;
    }


    /**
     * check if users can delete the $users
     *
     * @param User $user
     * @param User $user
     * @return boolean
     */
    public function delete(User $user, User $user)
    {
        return true;
    }


    public function before()
    {

    }

}

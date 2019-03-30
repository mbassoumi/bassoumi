<?php
/**
 * Created by Bassoumi Generation command.
 * User: Majd Bassoumi
 * Date: 30-03-2019
 * Time: 4:43 PM
 */

namespace Plugins\UserManagement\Policies;


use App\User;
//use Plugins\UserManagement\Models\User;

class UserPolicy
{


    /**
     * check if user can view the $user2
     *
     * @param User $user
     * @param User $user2
     * @return boolean
     */
    public function view(User $user, User $user2)
    {
        return true;
    }


    /**
     * check if user can edit the $user2
     *
     * @param User $user
     * @param User $user2
     * @return boolean
     */
    public function edit(User $user, User $user2)
    {
        return true;
    }


    /**
     * check if user can update the $user2
     *
     * @param User $user
     * @param User $user2
     * @return boolean
     */
    public function update(User $user, User $user2)
    {
        return true;
    }


    /**
     * check if user can create the $user2
     *
     * @param User $user
     * @param User $user2
     * @return boolean
     */
    public function create(User $user, User $user2)
    {
        return true;
    }


    /**
     * check if user can store the $user2
     *
     * @param User $user
     * @param User $user2
     * @return boolean
     */
    public function store(User $user, User $user2)
    {
        return true;
    }


    /**
     * check if user can delete the $user2
     *
     * @param User $user
     * @param User $user2
     * @return boolean
     */
    public function delete(User $user, User $user2)
    {
        return true;
    }


    public function before()
    {

    }

}
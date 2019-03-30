<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;


abstract class BassoumiRequest extends FormRequest
{


    /**
     * current request.
     *
     * @var array
     */
    protected $formRequest;

    /**
     * Model for the current request.
     *
     * @var array
     */
    protected $model;

    /**
     * User for the current request
     *
     * @var User
     */
    protected $user;


    /**
     * Constructor
     *
     * @param Request $request
     * @return void
     * @author
     **/
    public function __construct(Request $request)
    {
        $this->formRequest = $request;
        $this->user = $request->user();
    }

    /**
     * Check user of the request can do $action.
     *
     * @param string $action
     * @return bool
     **/
    protected function can($action)
    {
        return $this->formRequest->user()->can($action, $this->model);
    }


    /**
     * Check the request is create request.
     *
     * @return bool
     **/
    protected function isCreate()
    {

        if ($this->formRequest->is('*/create')) {
            return true;
        }

        return false;

    }


    /**
     * Check the request is store request.
     *
     * @return bool
     **/
    protected function isStore()
    {

        if ($this->formRequest->isMethod('POST')) {
            return true;
        }

        return false;
    }


    /**
     * Check the request is edit request.
     *
     * @return bool
     **/
    protected function isEdit()
    {

        if ($this->formRequest->is('*/edit')) {
            return true;
        }

        return false;

    }

    /**
     * Check the request is update request.
     *
     * @return bool
     **/
    protected function isUpdate()
    {

        if ($this->formRequest->isMethod('PUT') || $this->formRequest->isMethod('PATCH')) {
            return true;
        }

        return false;

    }

    /**
     * Check the request is delete request.
     *
     * @return bool
     **/
    protected function isDelete()
    {

        if ($this->formRequest->isMethod('DELETE')) {
            return true;
        }

        return false;

    }

}

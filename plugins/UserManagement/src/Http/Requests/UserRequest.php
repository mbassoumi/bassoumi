<?php
/**
 * Created by Bassoumi Generation command.
 * User: Majd Bassoumi
 * Date: 01-04-2019
 * Time: 2:43 PM
 */

namespace Plugins\UserManagement\Http\Requests;

use App\Http\Requests\BassoumiRequest as FormRequest;
use Plugins\UserManagement\Models\User;

class UserRequest extends FormRequest
{
    /**
     * Determine if the users is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->model = $this->route('users');

        if (is_null($this->model)){
            $this->model = new User();
        }

        if ($this->isCreate() || $this->isStore()) {
            // Determine if the users is authorized to create an entry,
            return $this->can('create');
        }

        if ($this->isEdit() || $this->isUpdate()) {
            // Determine if the users is authorized to update an entry,
            return $this->can('update');
        }

        if ($this->isDelete()) {
            // Determine if the users is authorized to delete an entry,
            return $this->can('destroy');
        }

        // Determine if the users is authorized to view the module.
        return $this->can('view');
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        if ($this->isStore()) {
            // validation rule for create request.
        }

        if ($this->isUpdate()) {
            // Validation rule for update request.
        }

        if ($this->isStore() || $this->isUpdate()) {
            // Validation rule for both of update and create request.
        }

        return $rules;
    }
}

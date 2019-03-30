<?php
/**
 * Created by PhpStorm.
 * User: majdbassoumi
 * Date: 2019-03-29
 * Time: 22:39
 */

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;


class Model extends Eloquent implements Transformable
{
    use TransformableTrait;

    protected $table;
    protected $casts;
    protected $dates;
    protected $fillable;

}

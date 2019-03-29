<?php
/**
 * Created by PhpStorm.
 * User: majdbassoumi
 * Date: 2019-03-29
 * Time: 22:54
 */

namespace App\Http\Controllers;



class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
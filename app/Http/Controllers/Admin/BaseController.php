<?php
/**
 * Created by PhpStorm.
 * User: ropp
 * Date: 2020/5/26
 * Time: 15:30
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class BaseController extends Controller
{

    protected $pageSize = 10;

    public function __construct()
    {
        $this->pageSize = config('page.pageSize');
    }
}

<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;


class PostController extends AdminController
{

    public function index()
    {
        return view
        (
            'admin/post',
            array(
                'js'    => 'js.post-js',
                'title' => 'BÀI VIẾT - MIBLOG'
            )
        );
    }

    function action(){

        return ('ACTION');
    }
}
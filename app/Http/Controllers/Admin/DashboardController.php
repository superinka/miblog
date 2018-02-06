<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;


class DashboardController extends AdminController
{
    
    public function index()
    {
        return view('admin/dashboard');
    }
}
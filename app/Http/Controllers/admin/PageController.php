<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/**
 * Class PageController
 *
 * @package App\Http\Controllers\admin
 */
class PageController extends AdminController
{
    public function index()
    {
        //$news = News::orderBy('id', 'desc')->paginate(Config::get('app.paginate.news'));

        return view('admin.page.index', [
            //'news' => $news
        ]);
    }
}

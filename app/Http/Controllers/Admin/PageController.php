<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Itstructure\GridView\DataProviders\EloquentDataProvider;
use App\Models\Page;


/**
 * Class PageController
 *
 * @package App\Http\Controllers\admin
 */
class PageController extends AdminController
{
    public function index()
    {
        $dataProvider = new EloquentDataProvider(Page::query());

        return view('admin.page.index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function delete(Request $request)
    {
        dd($request);
    }
}

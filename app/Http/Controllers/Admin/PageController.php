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
        /*$page = Page::find(11);
        $page->active = 0;
        $page->icon = 'ic';
        $page->title_en = 'New title 11';
        $page->title_ru = 'Новый тайтл 11';
        $page->description_ru = 'Новое описание 11';
        $page->save();

        $page = Page::find(11);
        dd($page->title_ru);*/

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

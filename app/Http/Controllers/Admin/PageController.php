<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Itstructure\GridView\DataProviders\EloquentDataProvider;
use App\Models\Page;
use App\Models\Language;
use App\Http\Requests\{StorePageRequest, UpdatePageRequest};


/**
 * Class PageController
 *
 * @package App\Http\Controllers\admin
 */
class PageController extends AdminController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $dataProvider = new EloquentDataProvider(Page::query());

        return view('admin.page.index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $languageList = Language::languageList();

        return view('admin.page.create', compact('languageList'));
    }

    /**
     * @param StorePageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StorePageRequest $request)
    {
        $model = new Page();

        foreach ($request->all() as $attribute => $value) {
            $model->{$attribute} = $value;
        }

        $model->save();

        return redirect()->route('admin_page_list');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $model = Page::findOrFail($id);
        $languageList = Language::languageList();

        return view('admin.page.edit', compact('model', 'languageList'));
    }

    /**
     * @param int $id
     * @param UpdatePageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(int $id, UpdatePageRequest $request)
    {
        $model = Page::findOrFail($id);

        foreach ($request->all() as $attribute => $value) {
            $model->{$attribute} = $value;
        }

        $model->save();

        return redirect()->route('admin_page_list');
    }

    public function delete(Request $request)
    {
        dd($request);
    }
}

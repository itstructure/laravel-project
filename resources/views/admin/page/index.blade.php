@section('title', 'Page list')
@extends('adminlte::page')
@section('content')

    <h1>Page list</h1>

    @php
    $gridData = [
        'dataProvider' => $dataProvider,
        'paginatorOptions' => [
            'pageName' => 'p',
        ],
        'rowsPerPage' => 5,
        'title' => 'Panel title',
        //'useFilters' => false,
        'strictFilters' => true,
        'columnFields' => [
            [
                'attribute' => 'id',
                'filter' => false
            ],
            [
                'label' => 'Active',
                'value' => function ($row) {
                    return '<span class="icon fas '.($row->active == 1 ? 'fa-check' : 'fa-times').'"></span>';
                },
                'format' => 'html',
                'attribute' => 'active',
                'filter' => [
                    'class' => Itstructure\GridView\Filters\DropdownFilter::class,
                    'data' => [
                        0 => 'No active',
                        1 => 'Active',
                    ]
                ],
            ],
            [
                'label' => 'Icon',
                'value' => function ($row) {
                    return $row->icon;
                },
                'attribute' => 'icon',
                'filter' => false,
                'format' => [
                    'class' => Itstructure\GridView\Formatters\ImageFormatter::class,
                    'htmlAttributes' => [
                        'width' => '100px'
                    ]
                ]
            ],
            'created_at',
            [
                'class' => Itstructure\GridView\Columns\ActionColumn::class,
                'actionTypes' => [
                    'view' => function ($data) {
                        return '/admin/pages/' . $data->id . '/view';
                    },
                    'edit' => function ($data) {
                        return '/admin/pages/' . $data->id . '/edit';
                    },
                    'delete',
                ],
                //'label' => false,
                //'width' => '12%'
            ],
            [
                'class' => Itstructure\GridView\Columns\CheckboxColumn::class,
                'field' => 'delete',
                'attribute' => 'id'
            ],
        ],
    ];
    @endphp

    @gridView($gridData)

@stop
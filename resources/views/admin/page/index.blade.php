@section('title', 'Page list')
@extends('adminlte::page')
@section('content')

    @php
    $gridData = [
        'dataProvider' => $dataProvider,
        'paginatorOptions' => [
            'pageName' => 'p',
        ],
        'rowsPerPage' => 5,
        'title' => 'Таблица',
        //'useFilters' => false,
        'strictFilters' => true,
        'columnFields' => [
            [
                'attribute' => 'id',
                'filter' => false,
                'htmlAttributes' => [
                    'width' => '5%',
                ],
            ],
            [
                'label' => 'Активно',
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
                'label' => 'Иконка',
                'value' => function ($row) {
                    return $row->icon;
                },
                'attribute' => 'icon',
                'filter' => false,
                'format' => [
                    'class' => Itstructure\GridView\Formatters\ImageFormatter::class,
                    'htmlAttributes' => [
                        'width' => '100'
                    ]
                ]
            ],
            [
                'label' => 'Создано',
                'attribute' => 'created_at'
            ],
            [
                'class' => Itstructure\GridView\Columns\ActionColumn::class,
                'actionTypes' => [
                    'view',
                    'edit' => function ($data) {
                        return '/admin/pages/' . $data->id . '/edit';
                    },
                    [
                        'class' => Itstructure\GridView\Actions\Delete::class,
                        'url' => function ($data) {
                            return '/admin/pages/' . $data->id . '/delete';
                        },
                        'htmlAttributes' => [
                            'target' => '_blank',
                            'onclick' => 'return window.confirm("Are you sure you want to delete?");'
                        ]
                    ],
                ],
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
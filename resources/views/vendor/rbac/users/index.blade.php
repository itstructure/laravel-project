@section('title', 'Users')
@extends(config('rbac.layout'))
@section('content')

    <section class="content container-fluid">

        @if ($errors->has('items'))
            <div class="row">
                <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3 text-center">
                    <div class="alert alert-danger" role="alert">
                        <strong>{{ $errors->first('items') }}</strong>
                    </div>
                </div>
            </div>
        @endif

        @php
            $gridData = [
                'dataProvider' => $dataProvider,
                'paginatorOptions' => [
                    'pageName' => 'p',
                ],
                'rowsPerPage' => 5,
                'title' => 'List users',
                'rowsFormAction' => route('delete_user'),
                'columnFields' => [
                    [
                        'label' => 'ID',
                        'attribute' => 'memberKey',
                        'htmlAttributes' => [
                            'width' => '5%',
                        ],
                        'filter' => false,
                        'sort' => false
                    ],
                    [
                        'label' => 'Name',
                        'value' => function ($user) {
                            return '<a href="' . route('show_user', ['id' => $user->memberKey]) . '">' . $user->memberName .'</a>';
                        },
                        'filter' => [
                            'class' => Itstructure\GridView\Filters\TextFilter::class,
                            'name' => 'name'
                        ],
                        'sort' => 'name',
                        'format' => 'html',
                    ],
                    [
                        'label' => 'Roles',
                        'value' => function ($user) {
                            $output = '';
                            foreach($user->roles as $role) {
                                $output .= '<a href="' . route('show_role', ['id' => $role->id]) . '">' . $role->name . '</a> <br>';
                            }
                            return $output;
                        },
                        'filter' => false,
                        'sort' => false,
                        'format' => 'html',
                    ],
                    [
                        'label' => 'Created',
                        'attribute' => 'created_at',
                        'filter' => false,
                    ],
                    [
                        'class' => Itstructure\GridView\Columns\ActionColumn::class,
                        'actionTypes' => [
                            'view' => function ($user) {
                                return '/rbac/users/show/' . $user->memberKey;
                            },
                            'edit' => function ($user) {
                                return '/rbac/users/edit/' . $user->memberKey;
                            }
                        ],
                        'htmlAttributes' => [
                            'width' => '130',
                        ],
                    ],
                    [
                        'class' => Itstructure\GridView\Columns\CheckboxColumn::class,
                        'field' => 'items',
                        'attribute' => 'memberKey',
                        'display' => function ($user) {
                            return Gate::allows(Itstructure\LaRbac\Models\Permission::DELETE_MEMBER_FLAG, $user->memberKey);
                        }
                    ],
                ],
            ];
        @endphp

        @gridView($gridData)

    </section>

@endsection

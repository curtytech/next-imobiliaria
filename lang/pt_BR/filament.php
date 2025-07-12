<?php

return [
    'pages' => [
        'dashboard' => [
            'title' => 'Dashboard',
        ],
    ],

    'resources' => [
        'filament-avatar' => [
            'url' => 'URL do Avatar',
        ],
    ],

    'components' => [
        'actions' => [
            'modal' => [
                'confirm' => [
                    'label' => 'Confirmar',
                ],
            ],
        ],

        'forms' => [
            'components' => [
                'repeater' => [
                    'add_action' => [
                        'label' => 'Adicionar',
                    ],
                ],
            ],
        ],

        'tables' => [
            'columns' => [
                'text' => [
                    'actions' => [
                        'collapse_all' => 'Recolher tudo',
                        'expand_all' => 'Expandir tudo',
                    ],
                ],
            ],

            'filters' => [
                'actions' => [
                    'apply' => 'Aplicar',
                    'remove' => 'Remover',
                    'remove_all' => 'Remover todos',
                ],
            ],
        ],
    ],

    'global_search' => [
        'no_results_message' => 'Nenhum resultado encontrado.',
    ],

    'layout' => [
        'actions' => [
            'modal' => [
                'actions' => [
                    'close' => 'Fechar',
                ],
            ],
        ],
    ],

    'notifications' => [
        'actions' => [
            'close' => 'Fechar',
        ],
    ],

    'pages' => [
        'auth' => [
            'login' => [
                'title' => 'Entrar',
                'form' => [
                    'actions' => [
                        'authenticate' => 'Entrar',
                    ],
                ],
            ],
        ],
    ],
]; 
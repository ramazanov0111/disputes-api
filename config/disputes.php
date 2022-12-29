<?php

return [
    'translate' => [
        'view' => 'просмотров',
        'comment' => 'комментариев',
        'like' => 'лайков',
        'dislike' => 'дизлайков',
    ],

    'methods' => [
        'default' => ['like', 'dislike', 'view', 'comment'],
        'custom' => ['top25', 'top100']
    ],

    'title' => [
        'default' => [
            'Будет ли status',
            'x type',
            'через y минут?'
        ]
    ]
];

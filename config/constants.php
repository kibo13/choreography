<?php

return [
    // default password
    'password'       => '123456',

    // form education
    'form_education' => [
        0 => 'Бюджетная',
        1 => 'Платная',
    ],

    // payments
    'payments'       => [
        0 => 'Не оплачено',
        1 => 'Оплачено',
    ],

    // types
    'types'          => [
        0 => 'Городское',
        1 => 'Международное',
    ],

    // days of week
    'days_of_week'   => [
        [
            'id'        => 1,
            'fullname'  => 'Понедельник',
            'shortname' => 'Пн',
            'slug'      => 'MO',
        ],
        [
            'id'        => 2,
            'fullname'  => 'Вторник',
            'shortname' => 'Вт',
            'slug'      => 'TU',
        ],
        [
            'id'        => 3,
            'fullname'  => 'Среда',
            'shortname' => 'Ср',
            'slug'      => 'WE',
        ],
        [
            'id'        => 4,
            'fullname'  => 'Четверг',
            'shortname' => 'Чт',
            'slug'      => 'TH',
        ],
        [
            'id'        => 5,
            'fullname'  => 'Пятница',
            'shortname' => 'Пт',
            'slug'      => 'FR',
        ],
        [
            'id'        => 6,
            'fullname'  => 'Суббота',
            'shortname' => 'Сб',
            'slug'      => 'SA',
        ],
        [
            'id'        => 0,
            'fullname'  => 'Воскресенье',
            'shortname' => 'Вс',
            'slug'      => 'SU',
        ]
    ],

    // blanks
    'blanks'         => [
        [
            'id'    => 1,
            'name'  => 'Бланк заявления о приеме в клубное формирование',
            'href'  => 'adult_app.pdf',
        ],
        [
            'id'    => 2,
            'name'  => 'Бланк заявления о приеме несовершеннолетнего ребенка в клубное формирование',
            'href'  => 'child_app.pdf',
        ],
        [
            'id'    => 3,
            'name'  => 'Согласие на сбор и обработку персональных данных',
            'href'  => 'adult_agreement.pdf',
        ],
        [
            'id'    => 4,
            'name'  => 'Согласие родителя (законного представителя) на сбор и обработку персональных данных ребенка',
            'href'  => 'child_agreement.pdf',
        ],
        [
            'id'    => 5,
            'name'  => 'Договор на оказание платных услуг',
            'href'  => 'contract.pdf',
        ],
        [
            'id'    => 6,
            'name'  => 'Анкета участника клубного формирования',
            'href'  => 'questionnaire.pdf',
        ],
    ]
];

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

    // blanks
    'blanks'         => [
        [
            'id'    => 1,
            'name'  => 'Бланк заявления о приеме в клубное формирование',
            'href'  => 'adult.pdf',
        ],
        [
            'id'    => 2,
            'name'  => 'Бланк заявления о приеме несовершеннолетнего ребенка в клубное формирование',
            'href'  => 'child.pdf',
        ],
        [
            'id'    => 3,
            'name'  => 'Договор на оказание платных услуг',
            'href'  => 'contract.pdf',
        ],
        [
            'id'    => 4,
            'name'  => 'Анкета участника клубного формирования',
            'href'  => 'questionnaire.pdf',
        ],
    ]
];

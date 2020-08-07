<?php
return [
    'binary' => [
      'yes' => 'yes',
      'no' => 'no'
    ],
    'object' => [
        'visibility' => [
            'internal' => [
                'get' => 'The :property is internal and can not be accessed.',
                'set' => 'The :property is internal and can not be defined.',
            ]
        ],
        'type' => [
            'int' => 'The :property value is not an integer.',
            'array' => 'The :property value is not an array.'
        ]
    ],
];

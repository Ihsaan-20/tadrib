$program = [];
$program = [
    'id' => 0
    'name' => 'Program name',
    'workouts' => [{
        'id' => 0,
        'name' => 'work name',
        'sets' => [{
            'id' => 0,
            'name' => 'set name',
            'exercise' => [{
                'id' => 0,
                'name' => 'exercise name'
           } ]
        }]
    }]
];


$program = [
    'id' => 0,
    'name' => 'Program name',
    'workouts' => [
        [
            'id' => 0,
            'name' => 'Workout 1',
            'sets' => [
                [
                    'id' => 0,
                    'name' => 'Set 1',
                    'exercise' => [
                        [
                            'id' => 0,
                            'name' => 'Exercise 1'
                        ],
                        [
                            'id' => 1,
                            'name' => 'Exercise 2'
                        ]
                    ]
                ],
                [
                    'id' => 1,
                    'name' => 'Set 2',
                    'exercise' => [
                        [
                            'id' => 2,
                            'name' => 'Exercise 3'
                        ],
                        [
                            'id' => 3,
                            'name' => 'Exercise 4'
                        ]
                    ]
                ]
            ]
        ],
        [
            'id' => 1,
            'name' => 'Workout 2',
            'sets' => [
                [
                    'id' => 0,
                    'name' => 'Set 1',
                    'exercise' => [
                        [
                            'id' => 4,
                            'name' => 'Exercise 5'
                        ],
                        [
                            'id' => 5,
                            'name' => 'Exercise 6'
                        ]
                    ]
                ],
                [
                    'id' => 1,
                    'name' => 'Set 2',
                    'exercise' => [
                        [
                            'id' => 6,
                            'name' => 'Exercise 7'
                        ],
                        [
                            'id' => 7,
                            'name' => 'Exercise 8'
                        ]
                    ]
                ]
            ]
        ]
    ]
];

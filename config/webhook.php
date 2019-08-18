<?php

return [

    'jobs' => [

        'IsTimeSlotFree'    => \App\Repository\Watson\IsTimeSlotFree::class,
        'Test1'             => \App\Repository\Watson\Test1::class,
        'Test'              => \App\Jobs\TestJob::class,

    ],

];

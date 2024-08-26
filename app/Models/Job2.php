<?php

namespace App\Models;

use Illuminate\Support\Arr;


class Job2 {
    public static function all() : array {
        return [
            [
                'id' => 1,
                'title' => 'Director',
                'salary' => '$50,000'
            ],
            [
                'id' => 2,
                'title' => 'Programmar',
                'salary' => '$12,000'
            ],
            [
                'id' => 3,
                'title' => 'Teacher',
                'salary' => '$8,000'
            ]
            ];
    }

    public static function find(int $id) : array {
        // $job = Arr::first($jobs, function($job) use($id) {
        //     return $jobs['id'] = $id;
        // });

        // this is new fn() syntax introduced in php 8.x

        $job = Arr::first(static::all(), fn($jobs)=>$jobs['id']==$id);

        if(! $job) {    // if job id not found throw 404 page
            abort(404);
        }

        return $job;
    }
}

?>

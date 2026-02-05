<?php

namespace App;

use App\Models\KTATemplate;

KTATemplate::all()->each(function($t) {
    echo $t->id . ': ' . $t->image_path . PHP_EOL;
});

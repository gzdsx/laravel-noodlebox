<?php

use App\Models\Page;

/**
 * @return Page|\Illuminate\Database\Eloquent\Builder
 */
function pages(){
    return Page::query();
}
<?php

use App\Models\Post;

/**
 * @return Post|\Illuminate\Database\Eloquent\Builder
 */
function posts()
{
    return Post::query();
}

function get_posts($args = [])
{
    return Post::filter($args)->get();
}
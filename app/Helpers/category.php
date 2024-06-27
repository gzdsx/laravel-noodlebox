<?php

use App\Models\Category;

function category()
{
    return Category::query();
}

function get_category($id)
{
    return Category::find($id);
}

function get_categories($options = [])
{
    return Category::filter($options)->get();
}
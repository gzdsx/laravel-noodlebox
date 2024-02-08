<?php

use App\Models\Category;

function get_category($id)
{
    return Category::find($id);
}

function get_categories($options = [])
{
    return Category::filter($options)->get();
}
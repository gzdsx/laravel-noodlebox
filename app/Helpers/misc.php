<?php

use App\Models\Snippet;

/**
 * @param $id
 * @return mixed|\Illuminate\Support\Collection|Snippet
 * @throws Exception
 */
function snippet($id)
{
    return cache()->rememberForever('snippet-' . $id, function () use ($id) {
        return Snippet::findOrNew($id);
    });
}
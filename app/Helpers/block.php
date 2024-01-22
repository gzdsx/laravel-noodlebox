<?php

use App\Models\Block;
use App\Models\BlockItem;

function blocks()
{
    return Block::query();
}

/**
 * @param $block_id
 * @return BlockItem[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
 */
function get_block_items($block_id)
{
    return BlockItem::whereBlockId($block_id)->get();
}
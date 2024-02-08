<?php

use App\Models\Post;

/**
 * @return Post|\Illuminate\Database\Eloquent\Builder
 */
function posts()
{
    return Post::query();
}

/**
 * @param $post_id
 * @return Post|Post[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
 */
function get_post($post_id)
{
    return Post::find($post_id);
}

function get_posts($args = [])
{
    return Post::filter($args)->get();
}

/**
 * @param $post
 * @return mixed|null
 */
function get_post_title($post)
{
    if (is_null($post)) {
        return null;
    }

    return apply_filters('post_title', $post->title, $post);
}

/**
 * @param $post
 * @return mixed|null
 */
function get_post_content($post)
{
    if (!$post) {
        return null;
    }

    if ($content = $post->content) {
        return apply_filters('post_content', $content->content, $post);
    }

    return apply_filters('post_content', '', $post);
}

/**
 * @param $post
 * @return mixed|null
 */
function get_post_excerpt($post)
{
    if (!$post) {
        return null;
    }

    return apply_filters('post_title', $post->excerpt, $post);
}

function get_post_url($post)
{
    if (!$post) {
        return null;
    }

    return apply_filters('post_url', $post->url, $post);
}
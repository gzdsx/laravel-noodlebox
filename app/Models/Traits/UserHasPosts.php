<?php
/**
 * ============================================================================
 * Copyright (c) 2015-2018 贵州大师兄信息技术有限公司 All rights reserved.
 * siteַ: http://www.dsxcms.com
 * ============================================================================
 * @author:     David Song<songdewei@163.com>
 * @version:    v1.0.0
 * ---------------------------------------------
 * Date: 2018/11/15
 * Time: 3:46 PM
 */

namespace App\Models\Traits;


use App\Models\Post;

trait UserHasPosts
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|Post
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|Post
     */
    public function collectedPosts()
    {
        return $this->belongsToMany(
            Post::class,
            'post_collect',
            'user_id',
            'post_id',
            'id',
            'id'
        )->as('subscribe')->withTimestamps()->orderBy('post_collect.created_at', 'desc');
    }
}

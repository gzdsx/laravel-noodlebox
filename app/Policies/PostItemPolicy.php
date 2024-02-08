<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostItemPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the post item.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Post $postItem
     * @return mixed
     */
    public function view(User $user, Post $postItem)
    {
        return true;
    }

    /**
     * Determine whether the user can create post items.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the post item.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Post $postItem
     * @return mixed
     */
    public function update(User $user, Post $postItem)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return $user->id == $postItem->id;
    }

    /**
     * Determine whether the user can delete the post item.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Post $postItem
     * @return mixed
     */
    public function delete(User $user, Post $postItem)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return $user->id == $postItem->id;
    }

    /**
     * Determine whether the user can restore the post item.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Post $postItem
     * @return mixed
     */
    public function restore(User $user, Post $postItem)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return $user->id == $postItem->id;
    }

    /**
     * Determine whether the user can permanently delete the post item.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Post $postItem
     * @return mixed
     */
    public function forceDelete(User $user, Post $postItem)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return $user->id == $postItem->id;
    }

    /**
     * @param User $user
     * @param Post $postItem
     * @return bool
     */
    public function own(User $user, Post $postItem)
    {
        return $user->id == $postItem->id;
    }

    /**
     * @param User $user
     * @param Post $postItem
     * @return bool
     */
    public function preview(User $user, Post $postItem)
    {
        if ($postItem->state == 1) {
            return true;
        }

        if ($user->isAdmin()) {
            return true;
        }
        return $user->id == $postItem->id;
    }
}

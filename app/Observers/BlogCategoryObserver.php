<?php

namespace App\Observers;

use App\Models\BlogCategory;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class BlogCategoryObserver
{
    public function creating(BlogCategory $blog_category)
    {
        //
    }

    public function updating(BlogCategory $blog_category)
    {
        //
    }
}
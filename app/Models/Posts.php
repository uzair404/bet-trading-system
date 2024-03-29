<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class, 'post_id')->whereNull('parent_id')->orderBy('id', 'DESC');
    }
    public function incrementReadCount() {
        $this->view_count++;
        return $this->save();
    }
}

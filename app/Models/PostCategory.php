<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;


class PostCategory extends Model
{
    use SoftDeletes;
    use NodeTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'parent_id',
        'slug',
        'valid',
        'description'
    ];

    public function childs() {
        return $this->hasMany('App\Models\PostCategory','parent_id','id') ;
    }
}

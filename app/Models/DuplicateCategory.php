<?php
class DuplicateCategory extends \Illuminate\Database\Eloquent\Model
{
    use \Kalnoy\Nestedset\NodeTrait;
    protected $table = 'post_category';
    protected $fillable = [ 'name' ];
    public $timestamps = false;
}
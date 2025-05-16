<?php

namespace App\Models\Content;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Menu extends Model
{
    use HasFactory, SoftDeletes,CascadeSoftDeletes;

    protected $fillable = ['name', 'url', 'parent_id', 'status'];
    protected $cascadeDeletes = ['children'];

    protected $dates = ['deleted_at'];
    public function children()
    {
        return $this->hasMany($this,'parent_id', 'id')->with('children');
    }

    public function parent()
    {
        return $this->belongsTo($this,'parent_id', 'id')->with('parent');
    }
}

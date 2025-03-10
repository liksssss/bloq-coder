<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mockery\Matcher\Type;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'thumbnail', 'description', 'parent_id'];

    public function scopeOnlyParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeSearch($query, $title)
    {
        return $query->where('title', 'LIKE', "%{$title}%");
    }

    public function parent() {
        return $this->belongsTo(self::class);
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
    public function descendants(Type $var = null) 
    {
        return $this->children()->with('descendants');
    }

    public function root()
    {
        return $this->parent ? $this->parent->root() : $this; 
    }
}

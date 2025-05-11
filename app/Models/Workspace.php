<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Workspace extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'code',
        'created_by'
    ];
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'workspace_user')->withTimestamps();
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    protected static function booted()
    {
        static::saving(function ($workspace) {
            $workspace->slug = Str::slug($workspace->name);
        });
    }
}

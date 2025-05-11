<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'workspace_id',
        'name',
        'slug',
        'description',
        'code'
    ];
    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    protected static function booted()
    {
        static::saving(function ($project) {
            $project->slug = Str::slug($project->name);
        });
    }
}

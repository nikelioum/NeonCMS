<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kalnoy\Nestedset\NodeTrait;
use Biostate\FilamentMenuBuilder\Traits\Menuable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Category extends Model
{
    use HasFactory, NodeTrait, LogsActivity, Menuable;

    protected $fillable = [
        'name',
        'description',
        'image',
        'status',
        'slug',
        'meta_title',
        'meta_description',
        'meta_image',
        'parent_id',
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['name', 'description']);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getMenuLinkAttribute(): string
    {
        return route('categories.show', $this);
    }
 
    public function getMenuNameAttribute(): string
    {
        return $this->name;
    }
}

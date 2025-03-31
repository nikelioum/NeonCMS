<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Biostate\FilamentMenuBuilder\Traits\Menuable;

class Page extends Model
{
    use HasFactory, Menuable;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'meta_title',
        'meta_description',
        'meta_image',
    ];


    public function getMenuLinkAttribute(): string
    {
        return route('pages.show', $this);
    }

    public function getMenuNameAttribute(): string
    {
        return $this->title;  // Fallback if 'title' is null
    }

    public static function getFilamentSearchLabel(): string
    {
        return 'title'; // Change this from 'name' to 'title'
    }
    
}

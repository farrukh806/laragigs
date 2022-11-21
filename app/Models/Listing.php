<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;
    // This $filleable property is used to submit forms 
    protected $fillable = ['company', 'location', 'title', 'description', 'website', 'email', 'tags', 'logo'];

    /*
     OR else we can do
     GOTO apps/Providers/AppServiceProvider.php/
     and in `boot` function write ---
     Model::unguard();

    */

    public function scopeFilter($query, array $filters){
        if($filters['tag'] ?? false){
            $query->where('tags','like', '%' . request('tag') . '%');
        }

        if($filters['search'] ?? false){
            $query->where('title','like', '%' . request('search') . '%') 
            ->orWhere('description', 'like', '%' . request('search') . '%')
            ->orWhere('tags', 'like', '%' . request('search') . '%')
            ->orWhere('company', 'like', '%' . request('search') . '%');
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rayon extends Model
{
     protected $table = 'rayons';

    protected $primaryKey = 'id_rayon';

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class, 'rayon_id', 'id_rayon');
    }
}

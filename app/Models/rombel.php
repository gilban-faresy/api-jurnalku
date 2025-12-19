<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rombel extends Model
{
     protected $table = 'rombels';

    protected $primaryKey = 'id_rombel';

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class, 'rombel_id', 'id_rombel');
    }
}

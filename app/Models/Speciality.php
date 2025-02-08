<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Speciality extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    protected $hidden = [ 'created_at', 'updated_at'];

    public function doctors() {
        return $this->belongsToMany(Doctor::class);
    }
}

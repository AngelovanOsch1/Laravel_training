<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeriesStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function seriesUsers()
    {
        return $this->hasMany(SeriesUser::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bidang extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'bidang';
    protected $guarded = ['id'];

    public function sektor()
    {
        return $this->belongsTo(Sektor::class, 'sektor_id');
    }
}

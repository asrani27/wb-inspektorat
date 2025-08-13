<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'profile';
    protected $guarded = ['id'];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }
    public function sektor()
    {
        return $this->belongsTo(Sektor::class, 'sektor_id');
    }
    public function fotoinstagram()
    {
        return $this->hasMany(Instagram::class, 'profile_id')->orderBy('realname','asc');
    }
}

<?php

namespace Modules\Tenants\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\User;
use Modules\Bookings\Entities\Booking;
use Modules\Teams\Entities\Team;

class Tenant extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

public function users()
{
    return $this->hasMany(User::class);
}

public function teams()
{
    return $this->hasMany(Team::class);
}

}

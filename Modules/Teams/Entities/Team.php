<?php

namespace Modules\Teams\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\User;
use Modules\Availability\Entities\TeamAvailability;
use Modules\Tenants\Entities\Tenant;
use Spatie\Multitenancy\Models\Concerns\UsesTenantModel;

class Team extends Model
{
    use HasFactory;
    use  UsesTenantModel;
    protected $fillable = [
        'tenant_id',
        'name',
        'description',
        'created_by', 
        'available'
    ];

        public function tenant()
        {
            return $this->belongsTo(Tenant::class);
        }

        public function users()
        {
            return $this->hasMany(User::class); // أو belongsToMany لو في جدول pivot
        }
        public function teamAvailability()
        {
            return $this->hasMany(TeamAvailability::class);
        }
        
}

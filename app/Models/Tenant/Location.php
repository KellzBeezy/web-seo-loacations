<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends TenantModel
{
    use HasFactory;

    /**
     * No tenant_id needed here as per your architecture.
     * The 'dynamic' connection handles the data isolation.
     */
    protected $fillable = [
        'city',
        'suburb',
        'change_frequency',
    ];
}
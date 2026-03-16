<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    // Ensure this matches your central connection name in config/database.php
    protected $connection = 'mysql';

    // Allow mass assignment for these fields
    protected $fillable = [
        'log_name',
        'description',
        'level',
        'user_id',
        'tenant_id',
        'properties'
    ];

    // Cast the properties column to an array automatically
    protected $casts = [
        'properties' => 'array',
    ];

    /**
     * Relationship: The user who triggered the activity.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: The tenant associated with this activity.
     */
    public function AppTenant(): BelongsTo
    {
        return $this->belongsTo(AppTenant::class);
    }

    /**
     * Helper: Get the color for the "Terminal" view based on level.
     */
    public function getTerminalColor(): string
    {
        return match ($this->level) {
            'error' => 'text-red-400',
            'warning' => 'text-yellow-400',
            'success' => 'text-emerald-400',
            default => 'text-green-400', // for 'info'
        };
    }
}
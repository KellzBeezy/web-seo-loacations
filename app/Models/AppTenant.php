<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Tenant\Role;

class AppTenant extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'app_tenants';

    protected $fillable = [
        'name',
        'domain',
        'db_host',
        'db_port',
        'db_name',
        'db_username',
        'db_password',
    ];

    protected $hidden = [
        'db_password',
    ];

    /**
     * Automatically encrypt DB password when setting
     */
    public function setDbPasswordAttribute($value)
    {
        $this->attributes['db_password'] = encrypt($value);
    }

    /**
     * Automatically decrypt DB password when retrieving
     */
    public function getDbPasswordAttribute($value)
    {
        // return decrypt($value);
        return $value;
    }

    /**
     * Find tenant by domain
     */
    public static function findByDomain(string $domain): ?self
    {
        return self::where('domain', $domain)->first();
    }

    /**
     * Example relationship (if users are central)
     */
    public function users()
    {
        return $this->hasMany(User::class, 'tenant_id');
    }

    /**
     * Example relationship (if roles are central)
     */
    public function roles()
    {
        return $this->hasMany(Role::class, 'tenant_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory;


    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'birthday',
        'civil_status',
        'contact_number',
        'image',
        'street',
        'brgy',
        'city',
        'province',
        'ec_name',
        'ec_address',
        'ec_contact',
        'ec_relation',
        'is_active'
    ];

    public function getFullNameAttribute()
    {
        return "{$this->last_name}, {$this->fist_name} {$this->middle_name}";
    }

    protected static function boot()
    {
        parent::boot();

        // When soft deleting, set is_active to false
        static::deleting(function ($patient) {
            if ($patient->isForceDeleting()) {
                return; // Skip if force deleting
            }
            $patient->is_active = false;
            $patient->saveQuietly(); // Prevent infinite loop
        });

        // When restoring, set is_active to true
        static::restoring(function ($patient) {
            $patient->is_active = true;
            $patient->saveQuietly();
        });
    }
}

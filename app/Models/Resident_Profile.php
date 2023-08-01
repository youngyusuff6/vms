<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident_Profile extends Model
{
    use HasFactory;
        
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'profile_image',
        'phone_number',
        'office_number',
        'office_number_updated',
        'address',
        'date_of_birth',
        'emergency_contact_name',
        'emergency_contact_number',
        'occupation',
        'company',
        'id_number',
        'vehicle_registration',
        'license_plate_number',
        // Add other fillable fields as needed
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // Add any hidden attributes if needed
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_of_birth' => 'date',
        // Add any other attribute casts if needed
    ];

    protected $table = 'resident_profile';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Security_Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'badge_number',
        'profile_image',
        'department',
        'shift_start_time',
        'shift_end_time',
        'contact_number',
        'emergency_contact_number',
        'job_title',
        'supervisor_name',
        'notes',
    ];

    protected $table = 'security_profile';
    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateBadgeId()
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $length = 6; // Updated length to 6
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }

    return 'B-' . $randomString;
}

}

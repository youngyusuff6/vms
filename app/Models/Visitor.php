<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    protected $fillable = [
        'resident_id',
        'unique_id',
        'name',
        'email',
        'phone_number',
        'purpose',
        'visit_date', 
        'visit_time',
        'sign_in_time',
        'sign_out_time',
        'status',
        'reg_type',
    ];

    // Add a method to generate a unique ID for visitors
    public static function generateUniqueId()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length = 5;
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return 'V-' . $randomString;
    }


    // Define the relationship with the Resident model
    public function resident()
    {
        return $this->belongsTo(Resident_Profile::class);
    }
}

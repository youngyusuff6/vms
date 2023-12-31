<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification_Description extends Model
{
    use HasFactory;
       // this property must be the same as the table name this model will control
       protected $table = 'notification_description';
       // set this to false if you do not want to use the primary key
       protected $primaryKey = "notification_id";
       // Here we creat the fillable property, to use it to declare the colums in our database table that can be mass assigned. 
       protected $fillable = [ 
        'owner_id', 
        'notification_controller_pipeline', 
        'notification_description', 
        'action_initiator_id', 
        'created_at', 
        'updated_at'
       ];
       // just set this property to false if you dont want to use timestamp
       public $timestamps = true;
}

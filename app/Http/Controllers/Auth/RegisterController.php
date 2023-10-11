<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Resident_Profile;
use App\Models\Security_Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Symfony\Component\HttpKernel\Profiler\Profile;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => 'required',
            'phone_number' => ['required', 'numeric', 'min:10'],
           
        ]);
    }
    
    

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Custom logic based on user role
        if ($data['role'] === 'security') {
            // Handle security registration
            $role = 'security';
        } else {
            // Handle other role registration
            $role = 'resident';
        }
    
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role,
        ]);
    
        // Create a profile and associate it with the user
        if ($role === 'security') {
             //Generate a unique ID for the visitor
            $BadgeNumber= Security_Profile::generateBadgeId();
            Security_Profile::create([
                'user_id' => $user->id,
                'badge_number' => $BadgeNumber
            ]);
        } else {
            $residentProfile = new Resident_Profile([
                'user_id' => $user->id,
                'phone_number' => $data['phone_number'],
                'office_number' => null,
                'address' => null,
                'occupation' => null,
                'emergency_contact_name' => null,
                'emergency_contact_number' => null,
                'id_number' => null,
                'vehicle_plate_number' => null,
            ]);
    
            $residentProfile->save();
        }
    
        return $user;
    }
    

    protected function register(Request $request)
{
    $this->validator($request->all())->validate();

    event(new Registered($user = $this->create($request->all())));

    $this->guard()->login($user);

    if ($user->role === 'security') {
        return redirect('/security/dashboard');
    } elseif ($user->role === 'resident') {
        return redirect('/resident/dashboard');
    }

    return redirect($this->redirectTo);
}


}

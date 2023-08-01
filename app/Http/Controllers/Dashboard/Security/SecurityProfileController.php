<?php

namespace App\Http\Controllers\Dashboard\Security;

use Illuminate\Http\Request;
use App\Models\Security_Profile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SecurityProfileController extends Controller
{
    public function index(){
        $SECURITY_DATA = Security_Profile::where('user_id',Auth::id())->get()->first();
        return view('dashboard.security.profile')->with([
            'SECURITY_DATA' => $SECURITY_DATA
        ]);
    }

    public function get_update_profile(){
        $SECURITY_DATA = Security_Profile::where('user_id',Auth::id())->get()->first();
            return view('dashboard.security.editprofile')->with([
                'SECURITY_DATA' => $SECURITY_DATA
            ]);
    }
    public function update_profile(Request $request)
    {
        // Get the authenticated user's security profile
        $securityProfile = Security_Profile::where('user_id', Auth::user()->id)->first();
    
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'contact_number' => 'required|numeric|min:11',
            'emergency_contact_number' => 'required|numeric|min:11',
            'job_title' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Update the security profile fields
        $securityProfile->contact_number = $request->input('contact_number');
        $securityProfile->emergency_contact_number = $request->input('emergency_contact_number');
        $securityProfile->job_title= $request->input('job_title');
        // Add other fields as needed
    
        // Save the changes
        $securityProfile->save();
    
        // Flash a success message to the session
        session()->flash('success_message', 'Profile updated successfully.');
    
        // Redirect back to the profile page with a success message
        return redirect()->route('security.profile');
    }
}

<?php

namespace App\Http\Controllers\Dashboard\Resident;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Resident_Profile;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\ResidentMiddleware;

class ResidentProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(ResidentMiddleware::class);
    }
    public function index(){
        $RESIDENT_DATA = Resident_Profile::where('user_id',Auth::id())->get()->first();;
        return view('dashboard.resident.profile')->with([
            'RESIDENT_DATA' => $RESIDENT_DATA
        ]);
    }

    public function get_update_profile(){
        $RESIDENT_DATA = Resident_Profile::where('user_id',Auth::id())->get()->first();;
            return view('dashboard.resident.editprofile')->with([
                'RESIDENT' => $RESIDENT_DATA
            ]);
    }

    
public function update_profile(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone_number' => 'required|numeric|min:11',
        'office_number' => [
            'alpha_num',
            function ($attribute, $value, $fail) use ($request) {
                $residentProfile = Resident_Profile::where('user_id', Auth::user()->id)->first();
                if ($residentProfile && $residentProfile->office_number_updated == 1 && $value !== $residentProfile->office_number) {
                    $fail('The office number cannot be modified. Kindly contact admin if your office number has changed');
                }
            }
        ],
        'address' => 'required',
        'date_of_birth' => 'date',
        'emergency_contact_name' => 'required|string',
        'emergency_contact_number' => 'required|numeric|min:11',
        'occupation' => 'required',
        'id_number' => 'required|numeric',
        'vehicle_plate_number' => 'string'

        ]);

    // Update user's name in the 'users' table
    $Update_User = User::where('id', Auth::user()->id)->update([
        'name' => $request->name,
    ]);

    // Update resident profile fields in the 'Resident_Profile' table
    $residentProfile = Resident_Profile::where('user_id', Auth::user()->id)->first();
    if (!$residentProfile) {
        // Create a new resident profile if it doesn't exist
        $residentProfile = new Resident_Profile();
        $residentProfile->user_id = Auth::user()->id;
    }

    $residentProfile->fill($request->except(['_token', 'name']));

    if ($residentProfile->office_number_updated != 1) {
        // Update the office_number if it hasn't been updated before
        $residentProfile->office_number = $request->office_number;
        $residentProfile->office_number_updated = true; // Set the flag to indicate it has been updated
    }
    $residentProfile->address = $request->address;
    $residentProfile->date_of_birth = $request->date_of_birth;
    $residentProfile->emergency_contact_name = $request->emergency_contact_name;
    $residentProfile->emergency_contact_number = $request->emergency_contact_number;
    $residentProfile->occupation = $request-> occupation;
    $residentProfile->id_number = $request-> id_number;
    $residentProfile->vehicle_plate_number = $request->vehicle_plate_number;

    $residentProfile->save();

    // // Show Toastr success message
    // Toastr::success('Profile updated successfully.', 'Success');
    //  // Redirect back or to another page
    //  return redirect()->back();
     // Show SweetAlert success message
     session()->flash('success_message', 'Profile updated successfully.');

     // Redirect back or to another page
     return redirect()->back();
}

public function uploadImage(Request $request)
{
    // Validate the uploaded image
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Get the authenticated user's ID
    $userId = auth()->id();
    
    // Retrieve the Resident_Profile model for the authenticated user
    $residentProfile = Resident_Profile::where('user_id', $userId)->first();
    if (!$residentProfile) {
        // Create a new Resident_Profile if it doesn't exist
        $residentProfile = new Resident_Profile();
        $residentProfile->user_id = $userId;
    }

    // Process and save the uploaded image
    $image = $request->file('image');
    $imageName = time() . '.' . $image->getClientOriginalExtension();

    $imagePath = "UPLOADS/RESIDENT/".$userId."/". $imageName;
    $image->move($imagePath);

    // Update the Resident_Profile model with the image path
    $residentProfile->image_path = $imagePath;
    $residentProfile->save();

    // Return a JSON response indicating success
    return response()->json(['success' => true]);
}
   }

<?php

namespace App\Http\Controllers\Dashboard\Security;

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class SecurityVisitorController extends Controller
{
    public function __construct()
{
    // Allow authenticated users to access the logout route
    $this->middleware('auth')->except('logout');
}
    public function register(){
        $Resident = User::where('role','=','resident')->get();
        return view('dashboard.security.visitregistration')->with([
            'residents' => $Resident
        ]);
    }

    public function registeration(Request $request)
{
    // Validate the form inputs
    $request->validate([
        'name' => 'required|max:100',
        'email' => 'required|email',
        'phone' => 'required|numeric|min:11',
        'purpose' => 'required|max:255',
        'visit_date' => 'required|date|after_or_equal:today',
        'visit_time' => 'required',
        'visitor' => 'required', // Add validation for the "Visitor" dropdown
    ]);

    // Get the form inputs
    $name = $request->input('name');
    $email = $request->input('email');
    $phone = $request->input('phone');
    $purpose = $request->input('purpose');
    $visitDate = $request->input('visit_date');
    $visitTime = $request->input('visit_time');
    $residentProfileId = $request->input('visitor'); // Get the selected visitor ID from the dropdown

    // Check if there is an overlapping visit
    $overlap = Visitor::where('visit_date', $visitDate)
        ->where('visit_time', $visitTime)
        ->exists();

    if ($overlap) {
        return redirect()->back()->withInput()->with('error_message', 'There is already a visitor registered at the same time.');
    }

    // Check if visit time is within office hours (e.g., 9:00 AM to 5:00 PM)
    $officeStartTime = Carbon::createFromTime(8, 0, 0); // Set office start time
    $officeEndTime = Carbon::createFromTime(18, 0, 0); // Set office end time

    $visitTime = Carbon::parse($visitTime); // Parse the visit time

    if ($visitTime->lt($officeStartTime) || $visitTime->gt($officeEndTime)) {
        return redirect()->back()->withInput()->with('error_message', 'Visit time must be within office hours.');
    }

    // Generate a unique ID for the visitor
    $visitorId = Visitor::generateUniqueId();


    // Create a new visitor record
    $visitor = new Visitor();
    $visitor->name = $name;
    $visitor->email = $email;
    $visitor->phone_number = $phone;
    $visitor->unique_id = $visitorId;
    $visitor->purpose = $purpose;
    $visitor->visit_date = $visitDate;
    $visitor->visit_time = $visitTime;
    $visitor->reg_type = "reg";
    $visitor->status = "Pending";
    $visitor->resident_id = $residentProfileId; // Associate with resident profile
    $visitor->save();

    // Show SweetAlert success message
    session()->flash('success_message', 'Visitor registered successfully. Visitor`s ID is ' . $visitorId);

    // Redirect back or to another page
    return redirect()->back();
}

    public function log(){
    $Log_object = Visitor::where('resident_id', '<>', NULL);
    $Log_count = $Log_object->count();
    $Log = $Log_object->latest('updated_at')->get();

    return view('dashboard.security.visitlog')->with([
        'LOG' => $Log,
        'LOG_COUNT' => $Log_count,
    ]);
    }

public function getValidation(Request $request)
{
    $visitor = null;
    $searchId = $request->query('search');

    if ($searchId) {
        // Search for the visitor by unique ID
        $visitor = Visitor::where('unique_id', $searchId)->first();
        if ($visitor) {
            if ($visitor->status === 'Success') {
                return redirect()->route('security.visitor.validate')->with('error_message', 'Visitor has already been validated.');
            }
            // If found, return the visitor details in the visitor_details view
            return view('dashboard.security.visitor_details', compact('visitor'));
        } else {
            // If not found, return an error message or redirect with a message
            session()->flash('error_message', 'Details not found!');
            return redirect()->back();
        }
    }

    return view('dashboard.security.validate', compact('visitor'));
}

public function postValidation(Request $request)
{
    $visitorId = $request->input('visitor_id');
    $visitor = Visitor::find($visitorId);
    if ($visitor) {
        // Update the status and signing time
        $visitor->sign_in_time = now();
        $visitor->status = 'In Progress';
        $visitor->save();

        return redirect()->route('security.visitor.log')->with('success_message', 'Visitor validated successfully.');
    }

    return redirect()->route('security.visitor.validate')->with('error_message', 'Visitor details not found.');
}

public function signout($id)
    {
        $id = DETOKENIZE($id);
        $visitor = Visitor::find($id);

        if ($visitor) {
            // Check if the visitor has already signed out
            if ($visitor->sign_out_time) {
                return redirect()->back()->with('error_message', 'Visitor has already signed out.');
            }

            // Get the current time and closing time (6:00 PM)
            $currentTime = Carbon::now();
            $closingTime = Carbon::createFromTime(18, 0, 0); // Closing time: 6:00 PM
            // Set the sign_out_time to the current time if it's before closing time, else set it to the closing time
            $visitor->sign_out_time = $currentTime->lt($closingTime) ? $currentTime : $closingTime;
            // Set status to completed
            $visitor->status = "Completed";
            
            $visitor->save();

            return redirect()->back()->with('success_message', 'Visitor signed out successfully.');
        }

        return redirect()->back()->with('error_message', 'Visitor not found.');
    }
    
}


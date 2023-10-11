<?php

namespace App\Http\Controllers\Dashboard\Security;

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
    
Validator::extend('visit_time_after_now', function ($attribute, $value, $parameters, $validator) use ($request) {
    $visitDate = $request->input('visit_date');
    $now = now();

    // Compare the visit_date with today
    $isToday = $visitDate === $now->format('Y-m-d');

    // If the visit_date is today, check if the visit_time is after the current time
    if ($isToday && $value <= $now->format('H:i')) {
        return false;
    }

    return true;
});

// ...

$USER_ID = Auth::id();
// Validate the form inputs
$request->validate([
    'name' => 'required|max:100',
    'email' => 'required|email',
    'phone' => 'required|numeric|min:11',
    'purpose' => 'required|max:255',
    'visit_date' => 'required|date|after_or_equal:today',
    'visit_time' => [
        'required_if:visit_date,' . now()->format('Y-m-d'),
        'visit_time_after_now',
    ],
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
    $visitor->registered_by = $USER_ID;
    $visitor->save();

    // Show SweetAlert success message
    session()->flash('success_message', 'Visitor registered successfully. Visitor`s ID is ' . $visitorId);

    // CONSTRUCT THE NOTIFICATION DESCRIPTION FOR RESIDENTS
    $NOTIFICATION_DESCRIPTION = ucfirst($name)." ". "with unique ID ". $visitorId ." wants to visit you, kindly check your log to validate their visit.";
    // REGISTER A NEW NOTIFICATION FOR THE RESIDENT WHO VISITOR WANTS TO VISIT.
    CREATE_NOTIFICATION($residentProfileId, "registered", $NOTIFICATION_DESCRIPTION);
    // // CONSTRUCT THE NOTIFICATION DESCRIPTION FOR SECURITY
    $SECURITY_NOTIFICATION_DESCRIPTION = "You have registered ".ucfirst($name)." with ID ".$visitorId.". Kindly wait for residents approval.";
    // REGISTER A NEW NOTIFICATION FOR THE STUDENT WHOSE APPLICATION HAVE JUST BEEN APPROVED.
    // CREATE_NOTIFICATION($USER_ID, "student_jobs_awaiting_confirmation", $STUDENT_NOTIFICATION_DESCRIPTION, $JOB_OWNER_ID);
    // HERE WE CREATE A NOTIFICATION DESCRIPTION IN THE DESCRIPTION TABLE ALONE, WITHOUT TAMPERING WITH THE NOTIFICATION PIPELINE TABLE.
    NOTIFICATION_DESCRIPTION_SETTER($USER_ID, "NONE", $SECURITY_NOTIFICATION_DESCRIPTION, $residentProfileId);

    //Mail
    // Send the email to the visitor
        Mail::send('emails.visitor_waiting', ['visitor' => $visitor], function ($message) use ($email) {
            $message->from('noreply@vms.unilorin.edu.ng', 'VMS');
            $message->to($email)->subject('Scheduled Visit Information');
        });
        
        $resident = User::where('id', $residentProfileId)->first(); // Use first() to get the user model
        $residentEmail = $resident->email; // Corrected 'mail' to 'email'
        Mail::send('emails.resident_notification', ['visitor' => $visitor, 'resident' => $resident], function ($message) use ($residentEmail, $visitor) {
            $message->from('noreply@vms.unilorin.edu.ng', 'VMS');
            $message->to($residentEmail)->subject('Visitor Waiting for Validation');
        });


    // Redirect back or to another page
    return redirect()->back();
}

    public function log(){
    $USER_ID = Auth::id();
    $Log_object = Visitor::where('resident_id', '<>', NULL);
    $Log_count = $Log_object->count();
    $Log = $Log_object->latest('updated_at')->get();
     // JUST INCASE WE HAVE A NEW NOTIFICATION COUNTED FOR THIS CONTROLLERS OUTPUT, WE RUN THIS FUNCTION TO NULLIFY IT.
    NOTIFICATION_PIPELINE_NULLIFIER($USER_ID, "accepted");
    NOTIFICATION_PIPELINE_NULLIFIER($USER_ID, "rejected");

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
            if ($visitor->status === 'Rejected' || $visitor->status === 'Completed' || $visitor->status === 'In Progress' ) {
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
    $validated_by = Auth::id();
    if ($visitor) {
        // Update the status and signing time
        $visitor->sign_in_time = now();
        $visitor->status = 'In Progress';
        $visitor->save();
    
         // CONSTRUCT THE NOTIFICATION DESCRIPTION FOR RESIDENTS
         $NOTIFICATION_DESCRIPTION = ucfirst($visitor->name)." ". "with unique ID ". $visitor->unique_id ." has been validated, Visitor is on their way!";
         // REGISTER A NEW NOTIFICATION FOR THE RESIDENT WHO VISITOR WANTS TO VISIT.
         CREATE_NOTIFICATION( $visitor->resident_id, "validated", $NOTIFICATION_DESCRIPTION);
         // // CONSTRUCT THE NOTIFICATION DESCRIPTION FOR SECURITY
         $SECURITY_NOTIFICATION_DESCRIPTION = "You have successfully validate ".ucfirst($visitor->name)." with ID ". $visitor->unique_id.". They should proceed to complete their visit.";
     
         NOTIFICATION_DESCRIPTION_SETTER( $validated_by , "NONE", $SECURITY_NOTIFICATION_DESCRIPTION, $visitor->resident_id);

       // Send the email to the visitor
            Mail::send('emails.visitor_validated', ['visitor' => $visitor], function ($message) use ($visitor) {
                $message->from('noreply@vms.unilorin.edu.ng', 'VMS');
                $message->to($visitor->email)->subject('Visit Validated');
            });


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


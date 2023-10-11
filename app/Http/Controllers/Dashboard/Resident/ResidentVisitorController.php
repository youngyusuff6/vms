<?php

namespace App\Http\Controllers\Dashboard\Resident;

use Carbon\Carbon;
use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ResidentVisitorController extends Controller
{
    public function register(){
        return view('dashboard.resident.visitregistration');
    }

    public function registeration(Request $request){ 
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
            ], // Ensure the visit_time is after or equal to the current time
        ]);
    
        // Get the form inputs
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $purpose = $request->input('purpose');
        $visitDate = $request->input('visit_date');
        $visitTime = $request->input('visit_time');

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


    //Generate a unique ID for the visitor
    $visitorId = Visitor::generateUniqueId();
    // Get the logged-in user's ID
    $residentProfileId = auth()->id();

    // Create a new visitor record
    $visitor = new Visitor();
    $visitor->name = $name;
    $visitor->email = $email;
    $visitor->phone_number = $phone;
    $visitor->unique_id = $visitorId;
    $visitor->purpose = $purpose;
    $visitor->visit_date = $visitDate;
    $visitor->visit_time = $visitTime;
    $visitor->status = "Pending";
    $visitor->resident_id = $residentProfileId; // Associate with resident profile
    $visitor->save();
     // Convert the datetime string to a Unix timestamp using strtotime
     $visitTimeTimestamp = strtotime($visitTime);

     // Format the time as "H:i A" to include AM or PM
    $formattedVisitTime = date('g:i A', $visitTimeTimestamp);
        // Construct the mail data
        $mailData = [
            'visitorId' => $visitorId,
            'name' => $name,
            'visitDate' => $visitDate,
            'visitTime' => $formattedVisitTime,
            'residentName' => Auth::user()->name,
            // Add any other data you want to pass to the email view
        ];
        // Send the email to the visitor
        Mail::send('emails.visitor_scheduled', $mailData, function ($message) use ($email) {
            $message->from('noreply@vms.unilorin.edu.ng', 'VMS');
            $message->to($email)->subject('Scheduled Visit Information');
        });
    // Show SweetAlert success message
    session()->flash('success_message', 'Visitor registered successfully. Visitor`s ID is '.$visitorId);

    $SECURITY_NOTIFICATION_DESCRIPTION = "You have registered ".ucfirst($name)." with ID ".$visitorId.". Visitor has been alerted via email. Please note, visitor is to go through validation at the security post.";
    // REGISTER A NEW NOTIFICATION FOR THE VISITOR WHOSE APPLICATION HAVE JUST BEEN APPROVED.
    // HERE WE CREATE A NOTIFICATION DESCRIPTION IN THE DESCRIPTION TABLE ALONE, WITHOUT TAMPERING WITH THE NOTIFICATION PIPELINE TABLE.
    NOTIFICATION_DESCRIPTION_SETTER($USER_ID, "NONE", $SECURITY_NOTIFICATION_DESCRIPTION, $residentProfileId);
        
    //MAIL


    // Redirect back or to another page
    return redirect()->back();
  }

  public function log(){
    $USER_ID = Auth::id();
    $Log_object = Visitor::where('resident_id', $USER_ID);
    $Log_count = $Log_object->count();
    $Log = $Log_object->latest('created_at')->get();
    // JUST INCASE WE HAVE A NEW NOTIFICATION COUNTED FOR THIS CONTROLLERS OUTPUT, WE RUN THIS FUNCTION TO NULLIFY IT.
    NOTIFICATION_PIPELINE_NULLIFIER($USER_ID, "accepted");
    NOTIFICATION_PIPELINE_NULLIFIER($USER_ID, "rejected");
    NOTIFICATION_PIPELINE_NULLIFIER($USER_ID, "validated");

    return view('dashboard.resident.visitlog')->with([
        'LOG' => $Log,
        'LOG_COUNT' => $Log_count,
    ]);
  }

  public function dispValidation(){
    $user_id = Auth::id();
    $visitor = Visitor::where('resident_id','=',$user_id)->where('reg_type','=','reg')->where('status','=','Pending');
    $visitors_count = $visitor->count();
    $visitors = $visitor->latest('updated_at')->get();

      // JUST INCASE WE HAVE A NEW NOTIFICATION COUNTED FOR THIS CONTROLLERS OUTPUT, WE RUN THIS FUNCTION TO NULLIFY IT.
      NOTIFICATION_PIPELINE_NULLIFIER($user_id, "registered");
      return view('dashboard.resident.validate')->with([
        'visitors' => $visitors,
        'visitors_count' => $visitors_count
    ]);
  }

  public function accept($id) {
    $id = DETOKENIZE($id);
    $user_id = Auth::id();
    $regulate_visit = Visitor::where('resident_id', $user_id)->where('status', '=', 'In Progress')->count();
    $visitor = Visitor::find($id);

    if ($visitor) {
        if ($regulate_visit >= 2) {
            return redirect()->route('resident.visitor.validation')->with('error_message', 'Meeting limits exceeded. Kindly end a meeting to validate visitor.');
        } else {
            // Update the status and signing time
            $visitor->sign_in_time = now();
            $visitor->status = 'In Progress';
            $visitor->save();

            // CONSTRUCT THE NOTIFICATION DESCRIPTION FOR RESIDENTS
            $NOTIFICATION_DESCRIPTION = ucfirst($visitor->name) . " with unique ID " . $visitor->unique_id . " has been accepted, visitor can proceed to complete their visit.";
            // REGISTER A NEW NOTIFICATION FOR THE RESIDENT WHO THE VISITOR WANTS TO VISIT.
            CREATE_NOTIFICATION($visitor->registered_by, "accepted", $NOTIFICATION_DESCRIPTION);
            
            // CONSTRUCT THE NOTIFICATION DESCRIPTION FOR SECURITY
            $SECURITY_NOTIFICATION_DESCRIPTION = "You have accepted " . ucfirst($visitor->name) . " with ID " . $visitor->unique_id . ". They are on their way!";
            // REGISTER A NEW NOTIFICATION FOR THE SECURITY STAFF.
            NOTIFICATION_DESCRIPTION_SETTER(Auth::id(), "NONE", $SECURITY_NOTIFICATION_DESCRIPTION, $visitor->registered_by);

            // MAIL
            Mail::send('emails.accepted', ['visitor' => $visitor], function ($message) use ($visitor) {
                $message->from('noreply@vms.unilorin.edu.ng', 'VMS');
                $message->to($visitor->email)->subject('Visit Request Accepted');
            });

            return redirect()->route('resident.visitor.log')->with('success_message', 'Visitor validated successfully.');
        }
    } else {
        return redirect()->route('resident.visitor.validation')->with('error_message', 'Visitor details not found.');
    }
}


  public function reject($id){
    $id = DETOKENIZE($id);
    $visitor = Visitor::find($id);
    if ($visitor) {
         // Update the status and signing time
         $visitor->sign_in_time = NULL;
         $visitor->status = 'Rejected';
         $visitor->save();
        //MAIL
    
        Mail::send('emails.rejected', ['visitor' => $visitor] , function ($message) use ($visitor) {
            $message->from('noreply@vms.unilorin.edu.ng', 'VMS');
            $message->to($visitor->email)->subject('Visit Request Rejected');
        });
          // CONSTRUCT THE NOTIFICATION DESCRIPTION FOR RESIDENTS
          $NOTIFICATION_DESCRIPTION = ucfirst($visitor->name)." ". "with unique ID ". $visitor->unique_id ." has been rejected, Visitor should leave the facility immediately!";
          // REGISTER A NEW NOTIFICATION FOR THE RESIDENT WHO VISITOR WANTS TO VISIT.
          CREATE_NOTIFICATION($visitor->registered_by, "rejected", $NOTIFICATION_DESCRIPTION);
          // // CONSTRUCT THE NOTIFICATION DESCRIPTION FOR SECURITY
          $SECURITY_NOTIFICATION_DESCRIPTION = "You have rejected ".ucfirst($visitor->name)." with ID ". $visitor->unique_id.". Security has been informed of the next step.";
      
          NOTIFICATION_DESCRIPTION_SETTER( Auth::id(), "NONE", $SECURITY_NOTIFICATION_DESCRIPTION, $visitor->registered_by);

         return redirect()->route('resident.visitor.log')->with('success_message', 'Visitor rejected successfully.');
    }
    else{
        return redirect()->route('resident.visitor.validation')->with('error_message', 'Visitor details not found.');
    }        
 }
}
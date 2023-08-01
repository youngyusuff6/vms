<?php

namespace App\Http\Controllers\Dashboard\Resident;

use Carbon\Carbon;
use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ResidentVisitorController extends Controller
{
    public function register(){
        return view('dashboard.resident.visitregistration');
    }

    public function registeration(Request $request){ 
        // Validate the form inputs
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email',
            'phone' => 'required|numeric|min:11',
            'purpose' => 'required|max:255',
            'visit_date' => 'required|date|after_or_equal:today',
            'visit_time' => 'required',
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

    // Show SweetAlert success message
    session()->flash('success_message', 'Visitor registered successfully. Visitor`s ID is '.$visitorId);

    // Redirect back or to another page
    return redirect()->back();
  }

  public function log(){
    $USER_ID = Auth::id();
    $Log_object = Visitor::where('resident_id', $USER_ID);
    $Log_count = $Log_object->count();
    $Log = $Log_object->latest('created_at')->get();

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

    return view('dashboard.resident.validate')->with([
        'visitors' => $visitors,
        'visitors_count' => $visitors_count
    ]);
  }

  public function accept($id){
        $id = DETOKENIZE($id);
        $user_id = Auth::id();
        $regulate_visit = Visitor::where('resident_id', $user_id)->where('status', '=', 'In Progress')->count();
        $visitor = Visitor::find($id);
        if ($visitor) {
             if($regulate_visit >= 2){
                return redirect()->route('resident.visitor.validation')->with('error_message', 'Meeting limits exceeded. Kindly end a meeting to validate visitor.');
             }else{
            // Update the status and signing time
            $visitor->sign_in_time = now();
            $visitor->status = 'In Progress';
            $visitor->save();
            return redirect()->route('resident.visitor.log')->with('success_message', 'Visitor validated successfully.');
          }
        }
        else{
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

         return redirect()->route('resident.visitor.log')->with('success_message', 'Visitor rejected successfully.');
    }
    else{
        return redirect()->route('resident.visitor.validation')->with('error_message', 'Visitor details not found.');
    }        
 }
}
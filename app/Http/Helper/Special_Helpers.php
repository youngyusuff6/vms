<?php

use Carbon\Carbon;


// LOAD ELOQUENT MODELS
use App\Models\User;
use App\Models\Resident_Profile;
use App\Models\Security_Profile;
use Illuminate\Support\Facades\Auth;







// FUNCTION TO HELP US LOAD IMAGE DATA OF LOGGED-IN MEMBER (STUDENT/BUSINESS). THIS FUNCTION LOADS THE THUMBNAIL VERSION OF USER IMAGE
function LOOPABLE_ACCOUNT_IMAGE_RESOLVER($USER_ID = false){
    // AFFIRM IF USER IS LOGGED-IN OR NOT. FUNCTION SHOULD RETURN FALSE IF USER IS NOT LOGGED-IN.
    if(Auth::user()){
        // Create an object of the user database table with respect to the id of the user we need access to its data.
        $MEMBER_DATA_OBJECT = User::where("id", "=", $USER_ID)->get()->first();

        //check user type to use to identify which database table to ping
        if($MEMBER_DATA_OBJECT->user_role === "student"){
            // Extract user image name from database
            $RESIDENT_DP_URL_DATA = Resident_Profile::where("user_id", "=", $USER_ID)->get()->first()->profile_image;
            // SET UP A CONSTRUCT TO VALIDATE THAT USER HAS A DP UPLOADED OR NOT, IF USER HAS A DP UPLOADED THEN CONSTRUCT A DIRECT
            // PATH TO THE DIRECTORY WHERE THE IMAGE IS, BUT IF USER HAS NOT UPLOADE ANY DP YET, THEN CONSTRUCT A PATH TO THE DEFAULT IMAGE.
            if(trim($RESIDENT_DP_URL_DATA) == ""){
                $INFO['DP_URL'] = "DASHBOARD_ASSETS/blank_avater.jpg";
            }else{
                $INFO['DP_URL'] = "UPLOADS/RESIDENT/".$USER_ID."/".$RESIDENT_DP_URL_DATA;
            }

            // Extract USER name data and save
            $INFO['NAME'] = $MEMBER_DATA_OBJECT->name;
            // return the final array result
            return $INFO;
        }else if($MEMBER_DATA_OBJECT->user_role === "security"){
            // Extract key business profile data object from database
            $SECURITY_DATA = Security_Profile::where("user_id", "=", $USER_ID)->get()->first();
            // Extract image url data
            $SECURITY_DP_URL_DATA = $SECURITY_DATA->profile_image;
            // SET UP A CONSTRUCT TO VALIDATE THAT USER HAS A DP UPLOADED OR NOT, IF USER HAS A DP UPLOADED THEN CONSTRUCT A DIRECT
            // PATH TO THE DIRECTORY WHERE THE IMAGE IS, BUT IF USER HAS NOT UPLOADE ANY DP YET, THEN CONSTRUCT A PATH TO THE DEFAULT IMAGE.
            if(trim($SECURITY_DP_URL_DATA) == ""){
                $INFO['DP_URL'] = "DASHBOARD_ASSETS/blank_avater.jpg";
            }else{
                $INFO['DP_URL'] = "UPLOADS/SECURITY/".$USER_ID."/".$SECURITY_DP_URL_DATA;
            }
             // Extract USER name data and save
             $INFO['NAME'] = $MEMBER_DATA_OBJECT->name;
             // return the final array result
             return $INFO;
        }
    }else{
        return false;
    }
}










function ACCOUNT_IMAGE_RESOLVER($USER_TYPE = "AUTO"){
    // AFFIRM IF USER IS LOGGED-IN OR NOT. FUNCTION SHOULD RETURN FALSE IF USER IS NOT LOGGED-IN.
    if(Auth::user()){
        // extract user ID from Auth
        $USER_ID = (Auth::user()->id);

        // Make this function smart, should user not set the role of the user-image to be fetched, this function will assume logged-in user is the
        // user we want to fetch image for and hence will get the role of logged-in user.
        $USER_TYPE = (Auth::user()->role);
        //check user type to use to identify which database table to ping
        if($USER_TYPE === "resident"){
            // Extract user image name from database
            $RESIDENT_DP_URL_DATA = Resident_Profile::where("user_id", "=", $USER_ID)->get()->first()->profile_image;
            // SET UP A CONSTRUCT TO VALIDATE THAT USER HAS A DP UPLOADED OR NOT, IF USER HAS A DP UPLOADED THEN CONSTRUCT A DIRECT
            // PATH TO THE DIRECTORY WHERE THE IMAGE IS, BUT IF USER HAS NOT UPLOADE ANY DP YET, THEN CONSTRUCT A PATH TO THE DEFAULT IMAGE.
            if(trim($RESIDENT_DP_URL_DATA) == ""){
                $INFO['DP_URL'] = "DASHBOARD_ASSETS/blank_avater.jpg";
            }else{
                $INFO['DP_URL'] = "UPLOADS/RESIDENT/".$USER_ID."/".$RESIDENT_DP_URL_DATA;
            }

            // Extract USER name data and save
            $INFO['NAME'] = Auth::user()->name;
            // return the final array result
            return $INFO;
        }else if($USER_TYPE === "security"){
            // Extract key business profile data object from database
            $SECURITY_DATA = Security_Profile::where("user_id", "=", $USER_ID)->get()->first();
            // Extract image url data
            $SECURITY_DP_URL_DATA = $SECURITY_DATA->profile_image;
            // SET UP A CONSTRUCT TO VALIDATE THAT USER HAS A DP UPLOADED OR NOT, IF USER HAS A DP UPLOADED THEN CONSTRUCT A DIRECT
            // PATH TO THE DIRECTORY WHERE THE IMAGE IS, BUT IF USER HAS NOT UPLOADE ANY DP YET, THEN CONSTRUCT A PATH TO THE DEFAULT IMAGE.
            if(trim($SECURITY_DP_URL_DATA) == ""){
                $INFO['DP_URL'] = "DASHBOARD_ASSETS/blank_avater.jpg";
            }else{
                $INFO['DP_URL'] = "UPLOADS/SECURITY/".$USER_ID."/".$SECURITY_DP_URL_DATA;
                // Extract USER name data and save
            }
            // return the final array result
            $INFO['NAME'] = Auth::user()->name;
            return $INFO;
        }
    }else{
        return false;
    }
}











// A FUNCTION TO DIFFERENTIATE BETWEEN TWO DATES AND CONSTRUCT A SHORT OUTPUT BETWEEN DAYS AND WEEKS. OUTPUT SHOULD LOOK LIKE THESE SAMPLES DEPENDING
// ON THE DATES INPUTED TO THIS FUNCTION => (I.E '1 day', '5 days', '3 weeks and 2 days',  '3 weeks and 1 day', '1 week and 2 days' 
// '1 week and 1 day', '1 week', '4 weeks'), TAKE NOTE OF THE PLURALS.
function DATE_DIFFERENTIATOR_IN_DAYS_AND_WEEKS($START_DATE, $END_DATE){
    // GET THE DIFFERENCE IN DAYS BETWEEN TWO DATES USING THE "diffInDays" PHP FUNCTION
    $difference_in_days = $END_DATE->diffInDays($START_DATE);
    // Check to affirm if the date difference in days is less than 7 days (7 days makes a week).
    if($difference_in_days >= 7){
        // control here means that the "date difference in days" is greater than 7, hence in a bid to construct a comprehensive output, we first 
        // attempt to calculate the number of weeks we have in here.
        $sections = $difference_in_days / 7;
        // since the "$sections" variable has the potential to tell us the number of weeks we have, we now run further process to ascertain if this
        // value is a decimal or not. if its a decimal it signifies that the "$sections" variable also has the potential to 
        // indicate to us that we have outstanding days left also. the output of this processing gives us an array.
        $detector = explode(".", $sections);
        // extracting the first part of this array which possibly gives us the whole number part of the initial value, this part is the one that 
        // represents the number of weeks. we run a construct to determine the numbers of weeks in question, and we use this number to define the 
        // plurality of the "week" word. We shall be needing this word (in its best singular and plural form) bellow.
        $week_plurality = ($detector[0] > 1) ? "weeks" : "week";
        // Now test to know if our array-index-count is two or one. if its two then our output will be in weeks and day form, but if its one, then
        // our output will be in weeks form alone
        if(count($detector) > 1){
            // Here we calculate the number of outstanding days let
            $outstanding_days_left = $difference_in_days - ($detector[0] * 7);
            // here we construct and return our final output.
            return $detector[0]." ".$week_plurality." and ".$outstanding_days_left." days";
        }else{
            // here we construct and return our final output.
            return $detector[0]." ".$week_plurality;
        }
    }else{
        // control here means that the "date difference in days" is less than 7, hence in a bid to construct a comprehensive output, we run a construct
        // to determine the numbers of days in question, and we use this number to define the plurality of the "day" word.
        $day_plurality = ($difference_in_days > 1) ? "days" : "day";
        // here we construct and return our final output.
        return $difference_in_days." ".$day_plurality;
    }
}












/** FUNCTION WE USE TO ENSURE LOGGED-IN-USER IS A STUDENT AND HAVE ACCESS TO WHAT A STUDENT USER SHOULD HAVE ACCESS TO, OR IS A BUSINESS AND HAVE
 *  ACCESS TO WHAT BUSINESS SHOULD HAVE ACCESS TO. THIS FUNCTION IS PUT IN PLACE AS A SECURITY MEASURE TO ENSURE USER DONT MANIPULATE URL DATA TO
 *  GAIN ACCESS TO A BUSINESS ACCOUNT WITH MORE ACCOUNT BALANCE. */
function USER_ACCESS_AUTHENTICATOR($SETTED_USER_TYPE, $REG_USER_TABLE_OBJECT = NULL, $ID = NULL){
    /** THE "$REG_USER_TABLE_OBJECT" PARAMETER, OF THIS FUNCTION IS SUPPOSE TO BE AN OBJECT OF THE REGISTERED_USER TABLE WHICH WE CAN USE TO FETCH
     *  THE USER-ROLE OF THE CURRENT LOGGED-IN USER. IN A CASE WHERE THIS FUNCTION IS CALLED AND THE "$REG_USER_TABLE_OBJECT" PARAMETER IS NOT
     *  DOPED THIS CLAUSE RIGHT HERE WILL BE ACTIVATED, WHICH WILL HELP THIS FUNCTION TO CREATE IT OWN "OBJECT OF THE REGISTERED_USER TABLE".  */
    if($REG_USER_TABLE_OBJECT === NULL){
        /**CREATE AN OBJECT CONTAINING DATAS FOR THE LOGGED IN USER, AS RECORDED IN THE REG_USER TABLE. */
        $REG_USER_TABLE_OBJECT = User::where("id", "=", $ID)->get()->first();
    }

    /** HERE WE RUN A TEST ON WHICH THE PROGRAMMER HAVE SETTED THE USER-ROLE TO BE AT THE POINT OF INVOKING THIS FUNCTION AGAINST WHAT THE DATABASE
     *  SAYS THIS USER ROLE IS, IF THEY ARE THESAME THEN THIS SIGNIFIES THAT LOGGED-IN-USER IS WHAT THEY CLAIM TO BE, BUT IF THEY ARE NOT THESAME
     *  THIS MEAN USER IS TRYING TO GHOST ANOTHER ROLE FOR MALICIOUSE REASONS, HENCE WE REDIRECT THEM STRAIGHT TO THE HOME PAGE.  */
    if($SETTED_USER_TYPE !== $REG_USER_TABLE_OBJECT->user_role){
        return TRUE;
    }else{
        return FALSE;
    }
}









// get latest messages from user
function getLatestMessage($user){
    $data = Message::query()
                ->where('sender_id', $user->sender_id)
                ->where('receiver_id', $user->receiver_id)
                ->orWhere('receiver_id', $user->sender_id)
                ->orWhere('sender_id', $user->receiver_id)
                ->latest()
                ->take(1)
                ->select('messages','file')->get()->toArray();

    return $data;
}







function seenMsgByUser($id){
    $result = \App\Models\Message::query()
        ->where('seen_by_receiver', $id)
        ->update([
            'is_seen' => 0
        ]);
    return $result;
}






function unseenMsgCount(){
    $msgCount =\App\Models\Message::query()
        ->where('seen_by_receiver', auth()->id())
        ->where('is_seen', 1)
        ->count();
    return $msgCount;
}







function get_user_status_check($user){

    date_default_timezone_set('Europe/London');
    $userT = $user->last_login;
    $date = Carbon::createFromFormat('l, jS \of F Y h:i:s a', $userT);
    $dateToString = $date->toIso8601String();
    $d = Carbon::parse($dateToString);
    $formattedDate = $d->format('Y-m-d H:i:s');

    $currentTIme = Carbon::now()->format('Y-m-d H:i:s');
    if($user->last_seen != null && $user->last_login != null && $currentTIme = $formattedDate){
        if($formattedDate > $user->last_seen){
            return 'online';
        }else{
            return 'offline';
        }
    }else{
        return 'offline';
    }

}


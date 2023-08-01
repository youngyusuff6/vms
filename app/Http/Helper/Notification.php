<?php

use Illuminate\Support\Facades\Auth;

// LOAD ELOQUENT MODELS
use App\Models\Notification_Controller_Pipeline;
use App\Models\Notification_Description;













// FUNCTION TO HELP US FETCH ALL NEW NOTIFICATION COUNT FROM THEIR RESPECTIVE PIPELINES AS INDICATED VIA THE "NOTIFICATION_PIPELINES" PARAMETER.
// THIS FUNCTION WILL RETURN AN ASSOCIATIVE ARRAY. INSIDE THE ASSOSIATIVE ARRAY WE HAVE AN INDEX CALLED "aggregate_notification", THIS IS WHERE
// YOU WILL FIND THE AGGREGATE/TOTAL NUMBER OF ALL NEW NOTIFICATIONS FOUND FROM DIFFERENT PIPELINES. DO A DD DUMP OF THIS FUNCTIONS OUTPUT TO
// FURTHER UNDERSTAND THE RESULT STRUCTURE.

// => "$NOTIFICATION_OWNER_ID" PARAMETER => IS USED TO SPECIFY THE USER WE ARE FETCHING THIS NOTIFICATION-COUNTING FOR.
// => "$NOTIFICATION_PIPELINES" PARAMETER => THIS INPUTE CAN BE A STRING (I.E "active_candidates") OR ARRAY OF
// STRINGS (I.E [ 'applying_candidates', 'active_candidates', 'candidates_awaiting_confirmation']), BUT BOTTOM LINE REMAINS THAT THE DATA ENTERED
// MUST HAVE NAMES THAT CORRELATE WITH THE NOTIFICATION-PIPELINES-COLUMN NAMES IN THE "notification_controller_pipeline" DATABASE TABLE, ELSE THIS
// FUNCTION WILL THROW A FATAL ERROR.
function NOTIFICATION_PIPELINES_HARVESTER($NOTIFICATION_OWNER_ID, $NOTIFICATION_PIPELINES){
    // Create a variable to store final result.
    $Result = [];
    // Run a function to fetch all new notifications related to the user account, from all the notification-pipelines specified to this function
    // via the "NOTIFICATION_PIPELINES" parameter.
    $Notification_Metrices = Notification_Controller_Pipeline::where("owner_id", "=", $NOTIFICATION_OWNER_ID)->get($NOTIFICATION_PIPELINES)->first();

    // Run a test to affirm if this user has a notification-pipelines account inside the "Notification_Controller_Pipeline" database table, if the
    // database query operation above went well then it means user has an account, else user doesn't and function will skip this till it returns zero
    // at the end.
    if(!$Notification_Metrices){
        // CONTROL IN HERE MEANS THAT THE USER WE ARE TRYING TO FETCH NOTIFICATIONS FOR DOESN'T HAVE A NOTIFICATION-PIPELINE SIGNED UP FOR THE USER.
        // HENCE WE CALL THIS FUNCTION TO CREATE A "NOTIFICATION_PIPELINE" ACCOUNT ON THE "Notification_Controller_Pipeline" DATABASE TABLE FOR THIS
        // MEMBER WHO DOESN'T HAVE BEFORE.
        NEW_MEMBER_PIPELINE_REGISTRA($NOTIFICATION_OWNER_ID);

        // AGAIN we Run a function to fetch all new notifications related to the user account, from all the notification-pipelines specified to this
        // function via the "NOTIFICATION_PIPELINES" parameter. Offcourse since pipeline is new we expect all data in pipelines to be zero.
        $Notification_Metrices = Notification_Controller_Pipeline::where("owner_id", "=", $NOTIFICATION_OWNER_ID)->get($NOTIFICATION_PIPELINES)->first();
    }

    // Use the data inside the "NOTIFICATION_PIPELINES" parameter to run a loop to fetch this notification counts, and structure the results
    // inside an array.
    foreach($NOTIFICATION_PIPELINES as $data) {
        $Result[$data] = $Notification_Metrices->$data;
    }

    // After fetching all notification-pipelines counts, we run this function to get the aggregate of all the notifications counts collected.
    $Result["aggregate_notification"] = array_sum($Result);

    // Here we return the final output at the end of the life cycle of this function.
    return $Result;
}















// FUNCTION TO HELP US FETCH ALL NOTIFICATION-DESCRIPTIONS ATTACHED TO ANY SPECIFIC MEMBER ACCOUNT
// => "$NOTIFICATION_OWNER_ID" PARAMETER => IS USED TO SPECIFY THE USER WE ARE FETCHING THIS NOTIFICATION-DESCRIPTION FOR.
// => "$NUMBER_OF_RECORDS_PER_PAGE" PARAMETER => IS USED TO SPECIFY THE NUMBER OF NOTIFICATION-DESCRIPTION RECORDS WE SHALL BE FETCHING AT ANY TIME.
// => "$PAGE_NUMBER" PARAMETER => IS OPTIONAL, IGNORE IT AND THIS FUNCTION WILL FETCH DATA IN ONE PHASE ONLY OR SET IT WITH AN INTEGER EACT TIME ITS
// CALLED TO SIGNIFY DIFFERENT PAGES/PHASES. THIS PARAMETER IS BASICALLY USED TO CONTROL PAGINATION FOR THIS FETCHER-FUNCTION.
function NOTIFICATION_FETCHER($NOTIFICATION_OWNER_ID, $NUMBER_OF_RECORDS_PER_PAGE, $PAGE_NUMBER = 1){
    // formular for Pagination.
    $OFFSET = ($PAGE_NUMBER - 1) * $NUMBER_OF_RECORDS_PER_PAGE;
    // Run the actual notification description fetching.
    return Notification_Description::where("owner_id", "=", $NOTIFICATION_OWNER_ID)->orderBy('notification_id', 'DESC')
        ->offset($OFFSET)->limit($NUMBER_OF_RECORDS_PER_PAGE)->get();
}















// FUNCTION TO HELP US RESET THE COUNT OF ANY NOTIFICATION-PIPELINE COLUMN BACK TO SERO
// => "$NOTIFICATION_OWNER_ID" PARAMETER => IS USED TO SPECIFY THE USER WE ARE UPDATING THIS NOTIFICATION-PIPELINE FOR.
// => "$NOTIFICATION_PIPELINE_COLUMN_NAME" PARAMETER => IS USED TO SPECIFY THE NAME OF THE NOTIFICATION PIPELINE COLUMN IN THE DATABASE, WE ARE GOING
// TO BE UPDATING BACK TO ZERO
function NOTIFICATION_PIPELINE_NULLIFIER($NOTIFICATION_OWNER_ID, $NOTIFICATION_PIPELINE_COLUMN_NAME){
    // Here we set up this eloquest snippet to take care of approving using job application
    return Notification_Controller_Pipeline::where('owner_id', $NOTIFICATION_OWNER_ID)->update([ $NOTIFICATION_PIPELINE_COLUMN_NAME => 0 ]);
}















// FUNCTION TO HELP US USE THE NOTIFICATION-PIPELINE DATA TO PRODUCE THE ROUTE EQUIVALENT TO THE CONTROLLER THAT IS DESIGNED TO SHOW THE DATA FOR THIS
// NOTIFICATION.
// => "$NOTIFICATION_PIPELINE" PARAMETER => IS USED TO SPECIFY THE EXACT NAME OF THE NOTIFICATION-PIPELINE WE WANT TO GET ROUTE FOR.
function NOTIFICATION_PIPELINE_TO_ROUTE_CONVERTER($NOTIFICATION_PIPELINE){
    // run a test on the inpute notification-pipeline and trandescend it into its equivalent route in this laravel project.
    if($NOTIFICATION_PIPELINE === "pre-registered"){
        return route('resident.visitor.log');
    }else if($NOTIFICATION_PIPELINE === "registered"){
        return route('security.visitor.log');
    }else if($NOTIFICATION_PIPELINE === "accepted"){
        return route('resident.visitor.log');
    }else if($NOTIFICATION_PIPELINE === "rejected"){
        return route('security.visitor.log');
    }else if($NOTIFICATION_PIPELINE === "validated"){
        return route('resident.visitor.log');
    }else if($NOTIFICATION_PIPELINE === "NONE"){
        return "";
    }else{
        // if no valide notification-pipeline is entered system will return the login page controller, and since user is already logged in, the loggin
        // controller will redirect user to either business or student dashboard, depending on who is currently logged-in.
        return route('login');
    }
}
















// A FUNCTION TO HELP EFFECT A NEW NOTIFICATION COUNT ON ANY PIPELINE AND ALSO CREATES A NEW NOTIFICATION DESCRIPTION HISTORY ON THE DATABASE WITH
// FULL TIMESTAMP. FUNCTION RETURNS TRUE OR FALSE.

// => "$NOTIFICATION_OWNER_ID" PARAMETER => IS USED TO SPECIFY THE USER WE ARE REGISTERING THIS NOTIFICATION FOR.
// => "$NOTIFICATION_PIPELINE" PARAMETER => IS USED TO SPECIFY A COLUMN INSIDE THE "notification_controller_pipeline" TABLE (NOTIFICATION0-PIPELINE)
// THAT WE SHALL BE INCREMENTING (AS A SIGN TO SHOW A CHANGE IN NOTIFICATION COUNT).
// => "$NOTIFICATION_DESCRIPTION" PARAMETER => IS OPTIONAL, SET IT WITH A STRING TO REPRESENT THE NOTIFICATION DESCRIPTION OR IGNORE THIS PARAMETER
// COMPLETELY TO SKIP REGISTERING ANY NOTIFICATION DESCRIPTION FOR THIS SESSION.
// => "$ACTION_INITIATOR" PARAMETER => IS OPTIONAL, SET IT WITH THE ID OF THE USER THAT HAS TRIGGERED AN ACTION THAT WARRANTS NOTIFICATION REGISTRATION.
// => "$PIPELINE_INCREMENTOR_DEFAULT_VALUE" PARAMETER => IS OPTIONAL, USE THIS PARAMETER TO SET THE NUMBER YOU WANT TO INCREMENT THE NOTIFICATION
// PIPELINE BY.
function CREATE_NOTIFICATION($NOTIFICATION_OWNER_ID, $NOTIFICATION_PIPELINE, $NOTIFICATION_DESCRIPTION = false, $ACTION_INITIATOR = null,
    $PIPELINE_INCREMENTOR_DEFAULT_VALUE = 1){
    // Here we call the "NOTIFICATION_PIPELINE_SETTER" function to help us set a new notification count on the notification-pipeline that needs a new
    // update on its counter. Note that this function can detect a user who is yet to register a new notification for the first time and also register
    // their first time notification for them.
    $NOTIFICATION_PIPELINE_SETTER_RESULT = NOTIFICATION_PIPELINE_SETTER($NOTIFICATION_OWNER_ID, $NOTIFICATION_PIPELINE, $PIPELINE_INCREMENTOR_DEFAULT_VALUE);
    // check out the output signal of the "NOTIFICATION_PIPELINE_SETTER" function, if everything is well from there then we go ahead to create the
    // notification description else this function will return false.
    if($NOTIFICATION_PIPELINE_SETTER_RESULT){
        // Control in here signifies that pipeline updating was a success. Since the "$NOTIFICATION_DESCRIPTION" is optional, we test if its false, if
        // its false it mean this function will not bother to create a notification-description for this session, but if its not false we shall assume
        // we have a string inside this parameter and use it as the notification-description
        if($NOTIFICATION_DESCRIPTION !== false){
            // Here we call the "NOTIFICATION_DESCRIPTION_SETTER" function to create the notification description
            NOTIFICATION_DESCRIPTION_SETTER($NOTIFICATION_OWNER_ID, $NOTIFICATION_PIPELINE, $NOTIFICATION_DESCRIPTION, $ACTION_INITIATOR);
        }

        // return true here to signify that all operation was a success
        return true;
    }else{
        // Control in here signifies that pipeline updating failed, therefore we return false here to signify that all operation collapsed
        return false;
    }
}














// A FUNCTION TO HELP UPDATE NEW NOTIFICATION COUNT ON THE "Notification_Controller_Pipeline" DATABASE TABLE FOR THE AFFECTED NOTIFICATION_PIPELINE.
// THIS FUNCTION GOES ALL THE WAY TO DETECT (when their is a pipeline update failure) WHEN A USER ACCOUNT IS YET TO HAVE A PIPELINE ACCOUNT OR WHEN
// A USER IS YET TO REGISTER A NEW NOTIFICATION ON THE PLATFORM, THIS FUNCTION CREATES THE PIPELINE IN THIS CASE AND STILL UPDATES IT.
function NOTIFICATION_PIPELINE_SETTER($NOTIFICATION_OWNER_ID, $PIPELINE_TO_SET, $PIPELINE_INCREMENTOR_DEFAULT_VALUE = 1){
    // update the database for the specific notification pipeline of the user account affected
    $NOTIFICATION_PIPELINE_UPDATE = Notification_Controller_Pipeline::where('owner_id', $NOTIFICATION_OWNER_ID)->increment($PIPELINE_TO_SET, $PIPELINE_INCREMENTOR_DEFAULT_VALUE);
    // run a check to affirm if update was effected on the database or not. if update is effected it simply means that the owner of this notification
    // already has a pipeline registered on this table and that all is well but if update fails to get reflected this indicates that owner of this
    // notification is yet to register their first ever notification on this platform, therefore we shall be creating them a new pipeline and also
    // updating the new notification too.
    if($NOTIFICATION_PIPELINE_UPDATE){
        return true;
    }else{
        if(Notification_Controller_Pipeline::create([ 'owner_id' => $NOTIFICATION_OWNER_ID, $PIPELINE_TO_SET => $PIPELINE_INCREMENTOR_DEFAULT_VALUE ])){
            return true;
        }else{
            return false;
        }
    }
}
















// A FUNCTION TO HELP CREATE A "NOTIFICATION_PIPELINE" ACCOUNT ON THE "Notification_Controller_Pipeline" DATABASE TABLE FOR ANY NEW MEMBER WHO DOESN'T
// HAVE BEFORE. THIS FUNCTION RETURNS TRUE IF PIPELINE CREATION GOES WELL AND FALSE IF IT FAILS. THIS FUNCTION TAKES IN THE ID OF THE MEMBER
// (BUSINESS/STUDENT) WE WANT TO CREATE THE PIPELINE FOR VIA THE "$NOTIFICATION_OWNER_ID" PARAMETER.
function NEW_MEMBER_PIPELINE_REGISTRA($NOTIFICATION_OWNER_ID){
    // Here we create a new NOTIFICATION_PIPELINE row for our newest member, who is yet to have a pipeline slot inside the "Notification_Controller_Pipeline"
    // database table. we return through if all things being nice and equal, but false if operation fails.
    if(Notification_Controller_Pipeline::create([ 'owner_id' => $NOTIFICATION_OWNER_ID ])){
        return true;
    }else{
        return false;
    }
}













// A FUNCTION TO HELP CREATE A NEW NOTIFICATION DESCRIPTION HISTORY ON THE DATABASE WITH FULL TIMESTAMP. SET $NOTIFICATION_PIPELINE_AFFECTED TO "NONE"
// IF YOU DONT WANT THIS NOTIFICATION DESCRIPTION TO REDIRECT TO A LOCATION WHEN CLICKED 
function NOTIFICATION_DESCRIPTION_SETTER($NOTIFICATION_OWNER_ID, $NOTIFICATION_PIPELINE_AFFECTED, $NOTIFICATION_DESCRIPTION, $ACTION_INITIATOR){
    // Create a new notification entry inside the "notification_description" database table to decribe the exact thing that just happened and reflect
    // the notification-pipeline affected
    Notification_Description::create([ 'owner_id' => $NOTIFICATION_OWNER_ID, 'notification_controller_pipeline' => $NOTIFICATION_PIPELINE_AFFECTED,
        'notification_description' => $NOTIFICATION_DESCRIPTION, 'action_initiator_id' => $ACTION_INITIATOR ]);
}


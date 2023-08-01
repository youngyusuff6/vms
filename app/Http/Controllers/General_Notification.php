<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification_Description;


class General_Notification extends Controller{



    public function Notifications($page_number){
    // Get the current logged-in business account ID
    $notificationOwnerId = Auth::user()->id;
    
    // Fetch the actual notifications using pagination
    $notifications = Notification_Description::where("owner_id", "=", $notificationOwnerId)
        ->paginate(10, ['*'], 'page', $page_number);

    // Pass the pagination data to the view
    $paginationSectionsCount = $notifications->lastPage();
    $paginationActingIndex = $notifications->currentPage();

    return view('dashboard.General_notification', [
        'EXTRA_DATAS' => [
            'total_number_Of_Rows' => $notifications->total(),
            'PAGINATION_SECTIONS_COUNT' => $paginationSectionsCount,
            'next_page_link' => route('general.notification.viewer', $paginationActingIndex + 1),
            'previous_page_link' => route('general.notification.viewer', $paginationActingIndex - 1),
            'PAGINATION_ACTING_INDEX' => $paginationActingIndex,
        ],
    ])->with('NOTIFICATION_DESCRIPTIONS', $notifications);
}





    // public function Messagess(){
    //     $sideBar = Message::where('read', 0)->where('receiver_id', Auth::user()->id)->count();

    //     return $sideBar;
    // }



}

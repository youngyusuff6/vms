<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification_Description;

use Illuminate\Support\Facades\View;
class General_Notification extends Controller{




    public function Notifications($page_number) {
        // Get the current logged-in user role
        $userRole = Auth::user()->role;
    
        // Get the current logged-in user ID
        $notificationOwnerId = Auth::user()->id;
    
        // Fetch the actual notifications using pagination in descending order by the creation date
        $notifications = Notification_Description::where("owner_id", "=", $notificationOwnerId)
            ->latest('created_at')
            ->paginate(10, ['*'], 'page', $page_number);
    
        // Pass the pagination data to the view
        $paginationSectionsCount = $notifications->lastPage();
        $paginationActingIndex = $notifications->currentPage();
    
        // Define the view name based on the user role
        $viewName = 'dashboard.General_notification';
    
        // Check if a specific view exists for the user role, if yes, use it
        if (View::exists('dashboard.' . strtolower($userRole) . '.General_notification')) {
            $viewName = 'dashboard.' . strtolower($userRole) . '.General_notification';
        }
    
        // Define the route name based on the user role
        $routeName = $userRole == 'security' ? 'general.notification.viewer' : 'general.notification.viewers';
    
        return view($viewName, [
            'EXTRA_DATAS' => [
                'total_number_Of_Rows' => $notifications->total(),
                'PAGINATION_SECTIONS_COUNT' => $paginationSectionsCount,
                'next_page_link' => route($routeName, $paginationActingIndex + 1),
                'previous_page_link' => route($routeName, $paginationActingIndex - 1),
                'PAGINATION_ACTING_INDEX' => $paginationActingIndex,
            ],
        ])->with('NOTIFICATION_DESCRIPTIONS', $notifications);
    }
    


}

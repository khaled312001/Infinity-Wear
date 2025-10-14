<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class ImporterSidebarComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $unreadNotificationsCount = 0;
        
        if (Auth::check() && Auth::user()->user_type === 'importer') {
            $unreadNotificationsCount = Notification::where('user_id', Auth::id())
                ->where('is_read', false)
                ->where('is_archived', false)
                ->count();
        }
        
        $view->with('unreadNotificationsCount', $unreadNotificationsCount);
    }
}

<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Helpers\SettingsHelper;

class SettingsComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with([
            'siteSettings' => SettingsHelper::getSiteInfo(),
            'contactSettings' => SettingsHelper::getContactInfo(),
            'socialSettings' => SettingsHelper::getSocialLinks(),
            'systemSettings' => SettingsHelper::getSystemSettings(),
        ]);
    }
}

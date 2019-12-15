<?php

use App\Models\CurrencyPaymentMethod;
use App\Models\GeneralSettings;
use App\Models\Meta;
use App\Models\Pages;
use App\Models\Preference;
use Illuminate\Support\Facades\Session;



function getCompanyLogo()
{
    $session = session('company_logo');
    if (!$session)
    {
        $session = GeneralSettings::first(['logo']);
        $session = $session->logo;
        session(['company_logo' => $session]);
    }
    return $session;
}


function getCompanyLogoWithoutSession()
{
    $logo = GeneralSettings::select(['logo'])->first(['logo'])->logo;
    return $logo;
}
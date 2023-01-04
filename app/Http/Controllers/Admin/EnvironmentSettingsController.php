<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use function App\CPU\translate;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class EnvironmentSettingsController extends Controller
{
    public function environment_index()
    {
        return view('admin-views.business-settings.environment-index');
    }

    public function environment_setup(Request $request)
    {
        if (env('APP_MODE') == 'demo') {
            Toastr::info(translate('you_can_not_update_this_on_demo_mode'));

            return back();
        }

        try {
            Helpers::setEnvironmentValue('APP_DEBUG', $request['app_debug'] ?? env('APP_DEBUG'));
            Helpers::setEnvironmentValue('APP_MODE', $request['app_mode'] ?? env('APP_MODE'));
        } catch (\Exception $exception) {
            Toastr::error('Environment variables updated failed!');

            return back();
        }

        Toastr::success('Environment variables updated successfully!');

        return back();
    }
}

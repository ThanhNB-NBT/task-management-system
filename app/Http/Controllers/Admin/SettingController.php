<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Cache::get('app_settings', [
            'app_name' => config('app.name'),
            'notification_email' => config('mail.from.address'),
            'items_per_page' => 10,
            'enable_notifications' => true,
            'maintenance_mode' => false,
        ]);
        
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'notification_email' => 'required|email',
            'items_per_page' => 'required|integer|min:5|max:100',
            'enable_notifications' => 'boolean',
            'maintenance_mode' => 'boolean',
        ]);

        $settings = $request->only([
            'app_name',
            'notification_email',
            'items_per_page',
            'enable_notifications',
            'maintenance_mode',
        ]);

        Cache::forever('app_settings', $settings);

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully');
    }
}
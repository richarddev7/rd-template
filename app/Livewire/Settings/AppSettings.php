<?php

namespace App\Livewire\Settings;

use App\Mail\TestMail;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class AppSettings extends Component
{
    use WithFileUploads;

    // Properties
    public $appName;
    public $themePrimaryColor;
    public $backgroundColor;
    public $registrationEnabled;
    public $defaultLanguage;

    // File uploads (temporary)
    public $logo;
    public $favicon;

    // Current file paths
    public $currentLogoPath;
    public $currentFaviconPath;

    // Test Email
    public $testEmailAddress = '';
    public $testEmailStatus = null; // null | 'success' | 'error'
    public $testEmailMessage = '';

    public function mount()
    {
        // Load current settings from database
        $this->appName = setting('app_name', 'RD Task Manager');
        $this->themePrimaryColor = setting('theme_primary_color', '#0ea5e9');
        $this->backgroundColor = setting('background_color', '#ffffff');
        $this->registrationEnabled = setting('registration_enabled', true);
        $this->defaultLanguage = setting('default_language', 'es');
        $this->currentLogoPath = setting('app_logo');
        $this->currentFaviconPath = setting('app_favicon');
    }

    public function updatedLogo()
    {
        $this->validate([
            'logo' => 'image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);
    }

    public function updatedFavicon()
    {
        $this->validate([
            'favicon' => 'image|mimes:ico,png,svg|max:512',
        ]);
    }

    public function removeLogo()
    {
        if ($this->currentLogoPath) {
            Storage::disk('public')->delete($this->currentLogoPath);
            Setting::set('app_logo', null, 'file');
            $this->currentLogoPath = null;
            session()->flash('success', __('Logo removed successfully.'));
        }
    }

    public function removeFavicon()
    {
        if ($this->currentFaviconPath) {
            Storage::disk('public')->delete($this->currentFaviconPath);
            Setting::set('app_favicon', null, 'file');
            $this->currentFaviconPath = null;
            session()->flash('success', __('Favicon removed successfully.'));
        }
    }

    public function save()
    {
        $this->validate([
            'appName' => 'required|string|max:255',
            'themePrimaryColor' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'backgroundColor' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'registrationEnabled' => 'boolean',
            'defaultLanguage' => 'required|in:en,es',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png,svg|max:512',
        ]);

        // Save text settings
        Setting::set('app_name', $this->appName, 'string');
        Setting::set('theme_primary_color', $this->themePrimaryColor, 'color');
        Setting::set('background_color', $this->backgroundColor, 'color');
        Setting::set('registration_enabled', $this->registrationEnabled, 'boolean');
        Setting::set('default_language', $this->defaultLanguage, 'string');

        // Handle logo upload
        if ($this->logo) {
            if ($this->currentLogoPath) {
                Storage::disk('public')->delete($this->currentLogoPath);
            }
            $path = $this->logo->store('settings', 'public');
            Setting::set('app_logo', $path, 'file');
            $this->currentLogoPath = $path;
            $this->logo = null; 
        }

        // Handle favicon upload
        if ($this->favicon) {
            if ($this->currentFaviconPath) {
                Storage::disk('public')->delete($this->currentFaviconPath);
            }
            $path = $this->favicon->store('settings', 'public');
            Setting::set('app_favicon', $path, 'file');
            $this->currentFaviconPath = $path;
            $this->favicon = null;
        }

        session()->flash('success', __('Settings saved successfully.'));
    }

    // Test Email Method
    public function sendTestEmail()
    {
        $this->validate([
            'testEmailAddress' => 'required|email',
        ], [
            'testEmailAddress.required' => __('Please enter a destination email address.'),
            'testEmailAddress.email' => __('Please enter a valid email address.'),
        ]);

        try {
            Mail::to($this->testEmailAddress)->send(new TestMail());
            $this->testEmailStatus = 'success';
            $this->testEmailMessage = __('Test email sent successfully to :email. Check your inbox (or the log if using the log driver).', ['email' => $this->testEmailAddress]);
        } catch (\Exception $e) {
            $this->testEmailStatus = 'error';
            $this->testEmailMessage = __('Failed to send test email: ') . $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.settings.app-settings');
    }
}

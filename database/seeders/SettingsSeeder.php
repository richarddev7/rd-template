<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'app_name', 'value' => ['RD Task Manager'], 'type' => 'string'],
            ['key' => 'app_logo', 'value' => [null], 'type' => 'file'],
            ['key' => 'app_favicon', 'value' => [null], 'type' => 'file'],
            ['key' => 'theme_primary_color', 'value' => ['#0ea5e9'], 'type' => 'color'],
            ['key' => 'background_color', 'value' => ['#ffffff'], 'type' => 'color'],
            ['key' => 'registration_enabled', 'value' => [true], 'type' => 'boolean'],
            ['key' => 'default_language', 'value' => ['es'], 'type' => 'string'],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type']
                ]
            );
        }
    }
}

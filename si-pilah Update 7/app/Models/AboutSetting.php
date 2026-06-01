<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSetting extends Model
{
    use HasFactory;

    protected $fillable = ['section', 'key', 'value', 'image', 'order'];

    /**
     * Get a setting value by section and key, with optional default.
     */
    public static function getValue(string $section, string $key, string $default = ''): string
    {
        $setting = static::where('section', $section)->where('key', $key)->first();
        return $setting ? ($setting->value ?? $default) : $default;
    }

    /**
     * Get a setting image by section and key.
     */
    public static function getImage(string $section, string $key): ?string
    {
        $setting = static::where('section', $section)->where('key', $key)->first();
        return $setting?->image;
    }

    /**
     * Get all settings for a section, ordered by 'order'.
     */
    public static function getSection(string $section)
    {
        return static::where('section', $section)->orderBy('order')->get();
    }

    /**
     * Set a value (upsert).
     */
    public static function setValue(string $section, string $key, ?string $value = null, ?string $image = null, int $order = 0): static
    {
        return static::updateOrCreate(
            ['section' => $section, 'key' => $key],
            array_filter([
                'value' => $value,
                'image' => $image,
                'order' => $order,
            ], fn($v) => $v !== null)
        );
    }
}

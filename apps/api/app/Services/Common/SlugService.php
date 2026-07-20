<?php

namespace App\Services\Common;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SlugService
{
    /**
     * Generate a unique slug for a model.
     *
     * @param class-string<Model> $modelClass
     */
    public function generate(string $modelClass, string $value): string
    {
        $slug = Str::slug($value);
        $originalSlug = $slug;
        $counter = 2;

        while ($modelClass::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

if (! function_exists('rowIndex')) {
    function rowIndex($iteration, $currentPage, $perPage)
    {
        return $iteration + ($currentPage - 1) * $perPage;
    }
}

if (! function_exists('assetUrl')) {
    function assetUrl($file_path)
    {
        return Storage::disk('public')->url($file_path);
    }
}

if (! function_exists('getInvoiceNo')) {
    function getInvoiceNo($table, $column, $prefix = 'ID', $length = 10)
    {
        $maxAttempts = 5;
        $batchSize = 20;

        do {
            $ids = collect(range(1, $batchSize))->map(function () use ($prefix, $length) {
                // Calculate the length of the random part
                $randomStringLength = $length - strlen($prefix);
                // Generate a truly random string
                $randomString = strtoupper(substr(bin2hex(random_bytes($randomStringLength)), 0, $randomStringLength));

                return $prefix.$randomString;
            });

            // Check which IDs already exist in the database
            $existingIds = DB::table($table)
                ->whereIn($column, $ids->toArray())
                ->pluck($column)
                ->toArray();

            // Filter out existing IDs
            $availableIds = $ids->diff($existingIds);

            // Use the first available ID
            if ($availableIds->isNotEmpty()) {
                $maxAttempts = 5;

                return $availableIds->first();
            }

            $maxAttempts--;
        } while ($maxAttempts > 0);

        throw new Exception('Unable to generate a unique ID after multiple attempts.'.$maxAttempts);
    }
}

if (! function_exists('userInfo')) {
    function userInfo(): ?User
    {
        $user = auth()->user();
        if (! $user) {
            throw new RuntimeException('No authenticated user found.');
        }

        return $user;
    }
}

if (! function_exists('customView')) {
    function customView($path = ['ajax' => '', 'default' => ''], $data = [])
    {
        $view = $path['default'];
        if (request()->ajax()) {
            $view = $path['ajax'];
        }

        return view($view, $data);
    }

}

if (! function_exists('variantText')) {
    function variantText($variations = [])
    {
        if (empty($variations)) {
            return null;
        }

        $text = '';
        foreach ($variations as $variation) {
            $text .= $variation->attribute->name.': '.$variation->attributeOption->attribute_value.', ';
        }

        return rtrim($text, ', ');
    }
}

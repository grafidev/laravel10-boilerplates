<?php

use App\Models\Settings;
use App\Models\User;
use Hibit\GeoDetect;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Jenssegers\Agent\Facades\Agent;
use libphonenumber\PhoneNumberUtil;
use Propaganistas\LaravelPhone\PhoneNumber;

if (! function_exists('parse_base_dn')) {
    function parse_base_dn(string $value, string $separator = '.'): string
    {
        $parts = explode($separator, $value);

        return collect($parts)
            ->map(fn ($item) => 'dc='.$item)
            ->join(',');
    }
}

if (! function_exists('humanFilesize')) {
    function humanFilesize($fileSize)
    {
        if ($fileSize < 1024) {
            $fileSize = $fileSize.' o';
        } elseif ($fileSize < 1048576) {
            $fileSize = round($fileSize / 1024, 2).' Ko';
        } else {
            $fileSize = round($fileSize / 1048576, 2).' Mo';
        }

        return $fileSize;
    }
}

if (! function_exists('settings')) {
    function settings($name, $default = null)
    {
        return Settings::getConfig($name, $default);
    }
}

if (! function_exists('action_log')) {
    function action_log(string $message, array $data = [], string $channel = 'actions', string $method = 'info'): void
    {
        $message = $message.'. [REQUEST PARAMETERS]: '.request_to_log().(request()->has('trx_id') ? '. [TRANSACTION ID]: '.request('trx_id') : '');

        $message = is_string($message) ? $message : json_encode($message);

        $authInstance = optional($channel === 'api_actions' ? auth('api') : auth());

        $defaultData = [
            'event_id' => Str::random(20),
            'status' => 'SUCCESS',
            'user_id' => $authInstance->id(),
            'user_name' => $authInstance->user()->name->full ?? '',
            'user_email' => $authInstance->user()->email ?? '',
            'description' => $message,
            'comment' => 'Sans commentaire',
            'date' => timezone_format(),
            'url' => Request::url(),
            'ip_address' => getIp(),
        ];

        try {
            $data = array_merge($defaultData, $data);
            Log::channel($channel)->{$method}($message, $data);
        } catch (\Throwable $th) {
            Log::warning("Erreur lors de l'écriture du fichier de log");
        }
    }
}

if (! function_exists('api_action_log')) {
    function api_action_log($message, $data = [])
    {
        action_log('API - '.$message, $data, 'api_actions');
    }
}

if (! function_exists('request_to_log')) {
    function request_to_log()
    {
        $hiddenAttributes = config('logging.hidden_attributes');

        $request = collect(request()->all());

        return json_encode($request->except($hiddenAttributes)->all());
    }
}

if (! function_exists('timezone_format')) {
    function timezone_format($date = null)
    {
        $date = is_null($date) ? now() : $date;

        return $date->toISOString();
    }
}

if (! function_exists('getIp')) {
    function getIp()
    {
        return $_SERVER['HTTP_X_CUSTOM_XFF'] ?? request()->ip();
    }
}

if (! function_exists('linesCount')) {
    function linesCount($path)
    {
        if (! file_exists($path)) {
            return 0;
        }

        $linecount = 0;

        $handleFile = fopen($path, 'r');

        while (! feof($handleFile)) {
            $line = fgets($handleFile);
            $linecount++;
        }

        fclose($handleFile);

        return $linecount;
    }
}

if (! function_exists('read_file_contents')) {
    function read_file_contents($file)
    {
        $fp = fopen($file, 'r');
        $contents = '';
        while (! feof($fp)) {
            $contents .= fread($fp, 1024);
        }
        fclose($fp);

        return $contents;
    }
}

if (! function_exists('get_csv_content')) {
    function get_csv_content($file)
    {
        $handle = fopen($file, 'r');

        // Initialize an empty array to hold the data
        $data = [];

        // Loop through each row of the CSV file and add it to the array
        while (($row = fgetcsv($handle)) !== false) {
            $data[] = $row;
        }

        // Close the file handle
        fclose($handle);

        return $data;
    }
}

if (! function_exists('current_company')) {
    function current_company()
    {
        return Cache::remember('current_company:'.auth()->id(), now()->addDay(), function () {
            return authUser()?->companies()?->first();
        });
    }
}

if (! function_exists('current_company_id')) {
    function current_company_id()
    {
        $company = current_company();

        return $company?->id;
    }
}

if (! function_exists('get_location_from_ip')) {
    function get_location_from_ip(string $ipAddress): Fluent
    {
        return \App\Services\Location::fromIp($ipAddress);
    }
}

if (! function_exists('format_phone_number')) {
    function format_phone_number(string $phoneNumber, string $countryCode = 'SN')
    {
        if ($phoneNumber === null) {
            return null;
        }

        return (new PhoneNumber($phoneNumber, ['SN']))->formatE164();
    }
}

if (! function_exists('is_valid_phone_number')) {
    function is_valid_phone_number(string $value, string $countryCode = 'SN')
    {
        try {
            $value = trim($value);

            if (empty($value)) {
                return false;
            }

            $phoneUtil = PhoneNumberUtil::getInstance();

            return $phoneUtil->isValidNumber(
                $phoneUtil->parse($value, $countryCode)
            );
        } catch (\Exception $e) {
            return false;
        }
    }
}

if (! function_exists('authUser')) {
    function authUser(): ?User
    {
        return auth()->user();
    }
}

if (! function_exists('generatePinCode')) {
    function generatePinCode($length = 6)
    {
        $pin = '';

        // Generate each digit of the PIN code
        for ($i = 0; $i < $length; $i++) {
            // Generate a random digit (0-9)
            $digit = random_int(0, 9);
            $pin .= $digit; // Append the digit to the PIN code
        }

        do {
            return $pin;
        } while (User::where('pin_code', $pin)->exists());
    }
}

if (! function_exists('toMonthName')) {
    function toMonthName(string $month): string
    {
        $monthNames = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aout', 'Sep', 'Oct', 'Nov', 'Déc'];
        [$year, $monthNumber] = explode('-', $month);

        return $monthNames[intval($monthNumber) - 1];
    }
}

if (! function_exists('geocoded_country')) {
    function geocoded_country()
    {
        try {
            $geoDetect = new GeoDetect();
            $country = $geoDetect->getCountry(request()->ip());

            return $country->getIsoCode();
        } catch (\Exception $e) {
            return null;
        }
    }
}

function generateUniqueRandomNumber($length = 12, $existingNumbers = [])
{
    $maxAttempts = 10000; // Maximum attempts to find a unique number
    $generatedNumber = '';

    for ($i = 0; $i < $maxAttempts; $i++) {
        $generatedNumber = str_pad(mt_rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);

        // Check if the generated number is unique
        if (! in_array($generatedNumber, $existingNumbers)) {
            // Add the generated number to the list of existing numbers
            $existingNumbers[] = $generatedNumber;

            // Save the list of existing numbers to ensure uniqueness in future generations
            // You might use a database or some other persistent storage for this purpose
            // For this example, I'll use a simple text file.

            // file_put_contents('existing_numbers.txt', implode("\n", $existingNumbers));

            break;
        }
    }

    return $generatedNumber;
}

if (! function_exists('get_current_country')) {
    function get_current_country()
    {
        $user = request()->user();

        return $user !== null && $user?->parent_user_id !== null ? $user->parent_user->country : $user?->country;
    }
}

if (! function_exists('isMac')) {
    function isMac()
    {
        return Agent::platform() === 'OS X';
    }
}

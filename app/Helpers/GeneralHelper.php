<?php
use App\Models\City;
use App\Models\Rate;
use App\Models\Time;
use App\Models\User;
use App\Models\State;
use App\Models\Country;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Language;
use App\Models\AditionalRate;
use App\Models\EmailAttachement;
use App\Models\ProductTranslate;
use App\Models\CategoryTranslate;
use App\Models\Client;
use App\Models\Exercice;
use App\Models\LanguageTranslate;
use App\Models\ProductAttachement;
use App\Models\MainSupplyTranslate;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Models\ManufacturerTranslate;
use App\Models\Numerotation;
use App\Models\TrackClientDocs;
use Dotenv\Util\Str;
use Illuminate\Support\Facades\Storage;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Carbon\Carbon;

/**
 * Get the ID of the default language.
 *
 * @return int|null The ID of the default language, or null if not found.
 */
if (!function_exists('getDefaultLangId')) {
    function getDefaultLangId()
    {
        $defaultLanguage = Language::where('isDefault', 1)->first();
        return $defaultLanguage;
    }
}
/**
 * Get the ID of the language based on the locale.
 *
 * @param string $locale The locale of the language.
 * @return int|null The ID of the language, or null if not found.
 */
if (!function_exists('getLangId')) {
    function getLangId($locale)
    {
        $language = Language::where('locale', $locale)->first()->id;
        return $language;
    }
}
/**
 * Get the name of the language based on the locale.
 *
 * @param string $locale The locale of the language.
 * @return string|null The name of the language, or null if not found.
 */
if (!function_exists('getLangName')) {
    function getLangName($locale)
    {
        $language = Language::where('locale', $locale)->first()->name;
        return $language;
    }
}
/**
 * Store translations for the current language to a language-specific JSON file.
 *
 * @return void
 */
if (!function_exists('storeTranslaionToLang')) {
    function storeTranslaionToLang()
    {
        $locale = App::getLocale();
        // $locale = 'en';
        $id = getLangId($locale);
        $objects = LanguageTranslate::where('language_id', $id)->pluck('translation', 'label');
        Storage::disk('lang')->delete($locale . '.json');
        Storage::disk('lang')->put($locale . '.json', $objects);
    }
}
/**
 * Store sidebar information as JSON file.
 *
 * @return void
 */
if (!function_exists('storeSidebar')) {
    function storeSidebar()
    {
        $sidebar = [
            'users' => User::count(),
            'roles' => Spatie\Permission\Models\Role::count(),
        ];
        Storage::put('public/sidebar/sidebar.json', json_encode($sidebar));
    }
}
/**
 * Get sidebar information from the stored JSON file.
 * If the file doesn't exist, it will be created using the storeSidebar() function.
 *
 * @return array The sidebar information as an associative array.
 */
if (!function_exists('getSidebar')) {
    function getSidebar()
    {
        $sideBarJson = Storage::disk('public')->get('sidebar/sidebar.json');
        if (!$sideBarJson) {
            storeSidebar();
        }
        return json_decode(Storage::disk('public')->get('sidebar/sidebar.json'), true);
    }
}
/**
 * Save settings from a database table to a JSON file.
 *

 * @return void
 */

if (!function_exists('storeSetting')) {
    function storeSetting()
    {
        $settings = Setting::pluck('option_value', 'option_name');
        Storage::disk('public')->put('settings/setting.json', $settings);
    }
}

if (!function_exists('getSettings')) {
    function getSettings()
    {
        $settings = json_decode(Storage::disk('public')->get('settings/setting.json'), true);
        if (!$settings) {
            $settings = Setting::pluck('option_value', 'option_name');
            Storage::disk('public')->put('settings/setting.json', $settings);
        }

        return $settings;
    }
}

/**
 * Get the active languages.
 *
 * @return \Illuminate\Database\Eloquent\Collection The collection of active languages.
 */

if (!function_exists('languages')) {
    function languages()
    {
        $langauge = Language::where('status', 1)->get();
        return $langauge;
    }
}
/**
 * Get the default language.
 *
 * @return \Illuminate\Database\Eloquent\Model|null The default language model, or null if not found.
 * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
 */
if (!function_exists('getDefaultLanguage')) {
    function getDefaultLanguage()
    {
        $langauge = Language::where('isDefault', 1)->first();
        return $langauge;
    }
}

/**
 * Accept file types.
 *
 * @return string The string of file types.
 */
if (!function_exists('acceptFileType')) {
    function acceptFileType()
    {
        return '.pdf,.doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.txt,.csv,.ppt,.pptx,.xls,.xlsx';
    }
}

/**
 * Accept file image types.
 *
 * @return string The string of file image types.
 */
if (!function_exists('acceptImageType')) {
    function acceptImageType()
    {
        return 'image/jpeg,image/png,image/gif,image/bmp';
    }
}

if (!function_exists('getClientNumerotation')) {
    function getClientNumerotation()
    {
        $num = Numerotation::where('doc_type', 'Client')->first();

        if (!$num) {
            throw new Exception('No Numerotation record found for doc_type "Client"');
        }
        $codeClient = $num->prefix . ($num->increment_num + 1);
        return $codeClient;
    }
}

if (!function_exists('incClientNumerotation')) {
    function incClientNumerotation()
    {
        $num = Numerotation::where('doc_type', 'Client')->first();
        $num->increment_num = $num->increment_num + 1;
        $num->save();
    }
}

if (!function_exists('getProduitNumerotation')) {
    function getProduitNumerotation()
    {
        $num = Numerotation::where('doc_type', 'Produit')
            ->latest()
            ->first();

        if (!$num) {
            throw new Exception('No Numerotation record found for doc_type "Client"');
        }
        $codeProduct = $num->prefix . $num->increment_num + 1;

        return $codeProduct;
    }
}

if (!function_exists('incProduitNumerotation')) {
    function incProduitNumerotation()
    {
        $num = Numerotation::where('doc_type', 'Produit')
            ->latest()
            ->first();
        $num->increment_num = $num->increment_num + 1;
        $num->save();
    }
}

if (!function_exists('getDevisNumerotation')) {
    function getDevisNumerotation()
    {
        $num = Numerotation::where('doc_type', 'Devis')
            ->latest()
            ->first();

        if (!$num) {
            throw new Exception('No Numerotation record found for doc_type "Client"');
        }
        $codeDevis = $num->prefix . $num->increment_num + 1;

        return $codeDevis;
    }
}

if (!function_exists('getCommandNumerotation')) {
    function getCommandNumerotation()
    {
        $num = Numerotation::where('doc_type', 'Command')
            ->latest()
            ->first();

        if (!$num) {
            throw new Exception('No Numerotation record found for doc_type "Client"');
        }
        $codeCommand = $num->prefix . $num->increment_num + 1;

        return $codeCommand;
    }
}

if (!function_exists('incCommandNumerotation')) {
    function incCommandNumerotation()
    {
        $num = Numerotation::where('doc_type', 'Command')
            ->latest()
            ->first();
        $num->increment_num = $num->increment_num + 1;
        $num->save();
    }
}

if (!function_exists('incDevisNumerotation')) {
    function incDevisNumerotation()
    {
        $num = Numerotation::where('doc_type', 'Devis')
            ->latest()
            ->first();
        $num->increment_num = $num->increment_num + 1;
        $num->save();
    }
}


if (!function_exists('getRegNumerotation')) {
    function getRegNumerotation()
    {
        $num = Numerotation::where('doc_type', 'Reglement')
            ->latest()
            ->first();

        if (!$num) {
            throw new Exception('No Numerotation record found for doc_type "Reglement"');
        }
        $codeCommand = $num->prefix . $num->increment_num + 1;

        return $codeCommand;
    }
}


if (!function_exists('incRegNumerotation')) {
    function incRegNumerotation()
    {
        $num = Numerotation::where('doc_type', 'Reglement')
            ->latest()
            ->first();
        $num->increment_num = $num->increment_num + 1;
        $num->save();
    }
}

if (!function_exists('getExercice')) {
    function getExercice()
    {
        $exercice = Exercice::where('etat', 'OUVERT')
            ->latest()
            ->first();
        return $exercice->exercice;
    }
}

if (!function_exists('getTotalGaranties')) {
    function getTotalGaranties($garanties)
    {
        $totalAmount = 0;

        foreach ($garanties as $gatanty) {
            $totalAmount += $gatanty->amount;
        }

        return $totalAmount;
    }
}

if (!function_exists('checkExpirationDate')) {
    function checkExpirationDate($givenDate)
    {
        $givenDate = Carbon::parse($givenDate);
        $currentDate = Carbon::now();
        $thresholdDays = 7;

       if ($givenDate->isPast()) {
            return 'expire';
        } elseif ($givenDate->diffInDays($currentDate) <= $thresholdDays) {
            return 'near';
        } else {
            return 'still';
        }
    }
}

if (!function_exists('getPrefix')) {
    function getPrefix($model)
    {
        $prefix = Numerotation::where('doc_type', $model)
        ->first();
         return $prefix->prefix;
    }
}



if (!function_exists('checkStatus')) {
    function checkStatus()
    {
         $status = [
            'issued'  =>  'Émis',
            'on_hold'  =>  'En attente',
            'present'  =>  'Présenté',
            'cashed'  =>  'Encaissé',
            'rejected'  =>  'Rejeté',
            'canceled'  =>  'Annulé',
            'expired'  =>  'Expiré',

        ];
         return $status;
    }
}
if (!function_exists('formatDateIndex')) {
    function formatDateIndex($date)
    {
       $dateVal = Carbon::createFromFormat('Y-m-d H:i:s',$date)->format('d/m/Y');
         return $dateVal;
    }
}
if (!function_exists('formatDateEdit')) {
    function formatDateEdit($date)
    {
       $dateVal = Carbon::createFromFormat('Y-m-d H:i:s',$date)->format('Y-m-d');
         return $dateVal;
    }
}
if (!function_exists('nombreEnLettres')) {
    function nombreEnLettres($nombre) {
        $units = ['', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf'];
        $teens = ['onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize', 'dix-sept', 'dix-huit', 'dix-neuf'];
        $tens = ['', 'dix', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante', 'soixante-dix', 'quatre-vingt', 'quatre-vingt-dix'];

        function convertLessThanThousand($number, $units, $teens, $tens) {
            $numText = '';
            if ($number < 10) {
                $numText = $units[$number];
            } elseif ($number < 20) {
                $numText = $teens[$number - 11];
            } elseif ($number < 100) {
                $numText = $tens[intdiv($number, 10)];
                if ($number % 10 !== 0) {
                    $numText .= '-' . $units[$number % 10];
                }
            } else {
                $numText = $units[intdiv($number, 100)] . ' cent';
                if ($number % 100 !== 0) {
                    $numText .= ' ' . convertLessThanThousand($number % 100, $units, $teens, $tens);
                }
            }
            return $numText;
        }

        if ($nombre === 0) {
            return 'zéro';
        }

        $numText = '';
        $billion = (int) ($nombre / 1000000000);
        $million = (int) (($nombre % 1000000000) / 1000000);
        $mille = (int) (($nombre % 1000000) / 1000);
        $reste = $nombre % 1000;

        if ($billion) {
            $numText .= convertLessThanThousand($billion, $units, $teens, $tens) . ' milliard ';
        }
        if ($million) {
            $numText .= convertLessThanThousand($million, $units, $teens, $tens) . ' million ';
        }
        if ($mille) {
            $numText .= convertLessThanThousand($mille, $units, $teens, $tens) . ' mille ';
        }
        if ($reste) {
            $numText .= convertLessThanThousand($reste, $units, $teens, $tens);
        }

        return trim($numText);
    }
}

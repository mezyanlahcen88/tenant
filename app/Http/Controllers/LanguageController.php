<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreLanguageRequest;
use App\Models\Language;
use App\Models\LanguageTranslate;
use Database\Seeders\LanguageTranslateSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
class LanguageController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-show|user-delete', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-show', ['only' => ['show']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('auth');
    }
    /**
     * Display a list of records.
     *
     * @return \Illuminate\View\View The view with the list of  records.
     */
    public function index()
    {
        $objects = Language::orderBy('status', 'desc')
            ->orderBy('isDefault', 'desc')
            ->where('visible', 1)
            ->get();
        return view('languages.index', compact('objects'));
    }
    /**
     * Show the form for creating a new record.
     *
     * @return \Illuminate\View\View The view with the record creation form and necessary data.
     */
    public function create()
    {
        return view('languages.create');
    }
    /**
     * Store a new  record in the database.
     *
     * @param \App\Http\Requests\Store recordRequest $request The validated  record creation request.
     * @return \Illuminate\Http\RedirectResponse The redirect response after successfully storing the  record.
     */
    public function store(StoreLanguageRequest $request)
    {
        $validated = $request->validated();
        $lang = new Language();
        $lang->name = $request->name;
        $lang->locale = $request->locale;
        $lang->direction = $request->direction;
        $lang->flag_path = $request->locale . '.png';
        $lang->save();
        storeSidebar();
        $seed = new LanguageTranslateSeeder();
        $seed->run($lang->id);
        Alert()->success(trans('translation.general_general_super'), trans('translation.language_message_store'));
        return redirect()->route('systemLanguages.index');
    }
    /**
     * Display the edit form for the specified records.
     *
     * @param int $id The ID of the records to be edited.
     * @return \Illuminate\View\View The view with the edit form for the records.
     */
    public function edit($id)
    {
        $object = Language::findOrFail($id);
        return view('languages.edit', compact('object'));
    }
    /**
     * Update the specified  record in the database.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object containing the form data.
     * @param int $id The ID of the  record to be updated.
     * @return \Illuminate\Http\RedirectResponse The redirect response after updating the  record.
     */
    public function update(StoreLanguageRequest $request, $id)
    {
        $validated = $request->validated();
        $lang = Language::findOrFail($id);
        $lang->name = $request->name;
        $lang->locale = $request->locale;
        $lang->direction = $request->direction;
        $lang->flag_path = $request->locale . '.png';
        $lang->save();
        Alert()->success(trans('translation.general_general_super'), trans('translation.language_message_update'));
        return redirect()->route('systemLanguages.index');
    }
    /**
     * Remove the specified record from storage.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance.
     * @param int $id The ID of the record to delete.
     * @return void
     */
    public function destroy($id)
    {
        $object = Language::findOrFail($id)->delete();
        storeSidebar();
        Alert()->success(trans('translation.general_general_super'), trans('translation.language_message_delete'));
        return redirect()->route('languages.index');
    }
    /**
     * Display the translations for a specific language.
     *
     * @param int $id The ID of the language for which to display translations.
     * @return \Illuminate\View\View The view with the translations for the specified language.
     */
    public function translations($id)
    {
        $count = LanguageTranslate::where('language_id', $id)->first();
        if (!$count) {
            alert()->error('Error', 'you should to activate this language');
            return redirect()->back();
        } else {
            $objects = LanguageTranslate::where('language_id', $id)->get();
            return view('languagetransations.index', compact('objects'));
        }
    }
    public function filterByKeyWord(Request $request, $id)
    {
        $keyword = $request->keyword;
        $objects = LanguageTranslate::where('language_id', $id)
            ->where(function ($query) use ($keyword) {
                $query->where('label', 'like', '%' . $keyword . '%')->orWhere('translation', 'like', '%' . $keyword . '%');
            })
            ->paginate(30)
            ->withQueryString();
        return view('languagetransations.index', compact('objects', 'id'));
    }
    public function changeDefault(Request $request)
    {
        $oldDefault = Language::where('isDefault', 1)->first();
        $oldDefault->isDefault = 0;
        $oldDefault->save();
        $id = $request->id;
        $object = Language::findOrFail($id);
        $object->isDefault = 1;
        $object->save();
        //  add code to check if this language is active first
        return response()->json(['code' => 200, 'lang' => $object->name]);
    }
    /**
     * Change the status (active/inactive) of a user.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @return \Illuminate\Http\JsonResponse The JSON response.
     */
    public function changeStatus(Request $request)
    {
        $id = $request->id;
        $object = Language::findOrFail($id);
        $object->status = !$object->status;
        $object->save();
        storeSidebar();
        $seed = new LanguageTranslateSeeder();
        $seed->run($id);
        $message = $object->isActive ? trans('translation.language_message_activated') : trans('translation.language_message_inactivated');
        return response()->json(['code' => 200, 'status' => $object->status, 'lang' => $object->name, 'message' => $message]);
    }
    /**
     * Set the application locale to the specified locale.
     *
     * @param string $locale The locale code to set (e.g., 'en', 'fr', 'es', etc.).
     * @return \Illuminate\Http\RedirectResponse The redirect response back to the previous page.
     */
    public function setLocale($locale)
    {
        App::setLocale($locale);
        Session::put('locale', $locale);
        return redirect()->back();
    }
    /**
     * Switch the application language to the specified language.
     *
     * @param string $lang The language code to switch to (e.g., 'en', 'fr', 'es', etc.).
     * @return \Illuminate\Http\RedirectResponse The redirect response back to the previous page.
     */
    public function switchLang($lang)
    {
        // if (array_key_exists($lang, getLanguagesKeys())) {
        App::setLocale($lang);
        Session::put('applocale', $lang);
        // }
        return Redirect::back();
    }
}

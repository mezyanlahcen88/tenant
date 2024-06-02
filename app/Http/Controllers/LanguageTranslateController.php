<?php

namespace App\Http\Controllers;

use App\Models\LanguageTranslate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LanguageTranslateController extends Controller
{
    /**
     * Display a list of records.
     *
     * @return \Illuminate\View\View The view with the list of  records.
     */
    public function index()
    {
        $objects = LanguageTranslate::orderBy('id','asc')->paginate(30);
        return view('languagetransations.index',compact('objects'));
    }

  /**
     * Show the form for creating a new record.
     *
     * @return \Illuminate\View\View The view with the record creation form and necessary data.
     */
    public function create()
    {
        return view('languagetransations.translation');
    }
/**
 * Translate a language label to the specified value and store it in the database.
 *
 * @param \Illuminate\Http\Request $request The HTTP request instance containing the translation value and label ID.
 * @return \Illuminate\Http\JsonResponse A JSON response indicating the success of the translation.
 */

    public function translate(Request $request){
        $id = $request->id;
        $toTranslate = LanguageTranslate::findOrFail($id);
        $toTranslate->translation = $request->value;
        $toTranslate->save();
        storeTranslaionToLang();
        return response()->json([
            'code'=>200,
            'label'=>$toTranslate->label,
        ]);
    }
/**
 * Filter the language translations by label or translation matching the specified keyword and language ID.
 *
 * @param \Illuminate\Http\Request $request The HTTP request instance containing the keyword and language ID.
 * @param string $id The ID of the language to filter the translations for.
 * @return \Illuminate\View\View The view displaying the filtered language translations.
 */
    public function filterByLabel(Request $request,$id){

       $keyword = $request->keyword;
       $objects = LanguageTranslate::where('label','like',"%$keyword%")
       ->orWhere('translation','like',"%$keyword%")
       ->where('langauge_id',$id)
       ->paginate(30);
       return view('languagetransations.index',compact('objects'));
    }


}

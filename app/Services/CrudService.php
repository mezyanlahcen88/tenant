<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

/**
 * Service des settings
 */
class CrudService
{

    public function storeRecord($model, $request, array $fillables, array $files, $concatName, $folder)
    {
        $record = $model;
        foreach ($request->only($fillables) as $key => $value) {
                $record->$key = $value;
        }

            foreach ($files as $file) {
                if($request->hasFile($file)){
                    dealWithPicture($request, $record, $file, $file, $folder, 'store');
                }
            }

        $record->save();
        // return true;
    }

    public function updateRecord($record, $request, array $fillables, array $files, $concatName, $folder)
    {
        foreach ($request->only($fillables) as $key => $value) {
            $record->$key = $value;
        }

        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                dealWithPicture($request, $record, $file, $file, $folder, 'update');
            }
        }

        $record->save();
        return true;
    }

}

<?php

namespace App\Http\Controllers;

use App\Imports\CategoriesImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class CategoryImportController extends Controller
{
    public function import(Request $request) {
        
        try {
            $request->validate([
                'file' => 'required|mimes:xls,xlsx',
            ]);
            $filePath = $request->file('file')->store('imports');
            Excel::import(new CategoriesImport, storage_path('app/' . $filePath));
            Storage::delete($filePath);
            return response()->json(['message' => 'Categories imported successfully'], 200);
        }catch (ValidationException $v) {
            return response()->json(['error' => $v->validator->errors()->first()], 422);
        } catch (\Maatwebsite\Excel\Exceptions\NoTypeDetectedException $e) {
            return response()->json(['error' => 'File type not supported'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong, please try again later'], 500);
        }
    }
}
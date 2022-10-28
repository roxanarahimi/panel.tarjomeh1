<?php

namespace App\Http\Controllers;

use App\Models\LanguageNameTranslate;
use Illuminate\Http\Request;
use App\Http\Resources\LanguageNameTranslateResource;
use Illuminate\Support\Facades\Validator;

class LanguageNameTranslateController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request['perPage'];
            $data = LanguageNameTranslate::latest();
            if ($request['language_id']){
                $data = $data->where('language_id', $request['language_id']);
            }
            if ($request['to_language_id']){
                $data = $data->where('to_language_id', $request['to_language_id']);
            }

            $data = $data->paginate($perPage);
            $pages_count = ceil($data->total() / $perPage);
            $labels = [];
            for ($i = 1; $i <= $pages_count; $i++) {
                (array_push($labels, $i));
            }
            return response([
                "data" => LanguageNameTranslateResource::collection($data),
                "pages" => $pages_count,
                "total" => $data->total(),
                "labels" => $labels,
                "name" => 'زبان ها ',
                "tooltip_new" => 'ثبت ترجمه جدید',

            ], 200);
        } catch (\Exception $exception) {
            return response($exception);

        }
    }
    public function indexSite(Request $request)
    {
        // dd($request->all());
        try {
            $data = LanguageNameTranslate::with('language');

            if ($request['to_id'] === null) {
                $data = $data->where('to_language_id', 1);

            }else{
                $data = $data->where('to_language_id',$request['to_id']);
            }
            $data = $data->get();

            return response(LanguageNameTranslateResource::collection($data), 200);
//            return response(new ProductResource($data), 200);
        } catch (\Exception $exception) {
            return response($exception);

        }
    }

    public function show(LanguageNameTranslate $languageNameTranslate)
    {
        try {


            return response(new LanguageNameTranslateResource($languageNameTranslate), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all('name'),
            [
                'name' => 'required|unique:LanguageNameTranslates,name',
            ],
            [
                'name.required' => 'لطفا عنوان را وارد کنید',
                'name.unique' => 'این عنوان قبلا ثبت شده است',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        try {
//            return $request['sizes'];
            $LanguageNameTranslate = LanguageNameTranslate::create($request->all());
            return response(new LanguageNameTranslateResource($LanguageNameTranslate), 201);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function update(Request $request, LanguageNameTranslate $LanguageNameTranslate)
    {
        $validator = Validator::make($request->all('name'),
            [
                'name' => 'required|unique:LanguageNameTranslates,name,' . $LanguageNameTranslate['id'],
            ],
            [
                'name.required' => 'لطفا عنوان را وارد کنید',
                'name.unique' => 'این عنوان قبلا ثبت شده است',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        try {
            $LanguageNameTranslate->update($request->all());
            return response(new LanguageNameTranslateResource($LanguageNameTranslate), 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

    public function destroy(LanguageNameTranslate $languageNameTranslate)
    {

        try {
//            $LanguageNameTranslate->sizes->each->delete(); // delete translations
            $languageNameTranslate->delete();
            return response('LanguageNameTranslate deleted', 200);
        } catch (\Exception $exception) {
            return response($exception);
        }
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        try {
            $perPage = $request['perPage'];
            $data = Article::latest()->paginate($perPage);
            $pages_count = ceil($data->total()/$perPage);
            $labels = [];
            for ($i=1; $i <= $pages_count; $i++){
                (array_push($labels,$i));
            }
            return response([
                "data"=>ArticleResource::collection($data),
                "pages"=>$pages_count,
                "total"=> $data->total(),
                "labels"=> $labels,
                "title"=> 'مطالب',
                "tooltip_new"=> 'ثبت مطلب جدید',

            ], 200);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), (integer)$exception->getCode());

        }
    }

    public function latest()
    {
        try {
            $data = Article::all()->sortByDesc('id')->take(3);
            return response(ArticleResource::collection($data), 200);
        } catch (\Exception $exception) {
            return response($exception->getMessage(), (integer)$exception->getCode());

        }
    }

    public function show(Article $article)
    {
        try {
            return response(new ArticleResource($article), 200);
        } catch (\Exception $exception) {
//            return response($exception->getMessage(), (integer)$exception->getCode());
            return response([$exception->getMessage(), (integer)$exception->getCode()], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all('title'),
            [
                'title' => 'required|unique:articles,title',
            ],
            [
                'title.required' => 'لطفا عنوان را وارد کنید',
                'title.unique' => 'این عنوان قبلا ثبت شده است',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        try {
            $data = Article::create($request->except('image','image_codes','image_names','text'));
            if ($request['image']) {
                $name = 'article_' . $data['id'] . '_' . uniqid() . '.jpg';
                $image_path = (new ImageController)->uploadImage($request['image'], $name, 'images/');
//                (new ImageController)->resizeImage('images/', $name);
                $data->update(['image' => '/' . $image_path]);
            }

            $text = $request['text'];
            $text = str_replace('<span>', '', $text);
            $text = str_replace('</span>', '', $text);
            $data->update(['text' => $text]);
            return response(new ArticleResource($data), 201);
        } catch (\Exception $exception) {
//            return response($exception->getMessage(), (integer)$exception->getCode());
            return response([$exception->getMessage(), (integer)$exception->getCode()], 500);
        }
    }

    public function update(Request $request, Article $article)
    {
//        return $request;

        $validator = Validator::make($request->all('title'),
            [
                'title' => 'required|unique:articles,title,' . $article['id'],
            ],
            [
                'title.required' => 'لطفا عنوان را وارد کنید',
                'title.unique' => 'این عنوان قبلا ثبت شده است',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        try {
            $article->update($request->except('image','text'));

            if ($request['image']) {
                $name = 'article_' . $article['id'] . '_' . uniqid() . '.jpg';
                $image_path = (new ImageController)->uploadImage($request['image'], $name, 'images/');
//                (new ImageController)->resizeImage('images/', $name);
                $article->update(['image' => '/' . $image_path]);
            }
            $text = $request['text'];
            $text = str_replace('<span>', '', $text);
            $text = str_replace('</span>', '', $text);
            $article->update(['text' => $text]);

            return response(new ArticleResource($article), 200);
        } catch (\Exception $exception) {
//            return response($exception->getMessage(), (integer)$exception->getCode());
            return response($exception);
        }
    }

//    public function destroy(Article $article)
    public function destroy(Request $request)
    {
        $data = Article::findOrFail($request['id']);
        try {
            $data->delete();
            return response('article deleted', 200);
        } catch (\Exception $exception) {
//            return response($exception->getMessage(), (integer)$exception->getCode());
            return response([$exception->getMessage(), (integer)$exception->getCode()], 500);
        }
    }

    public function activeToggle(Article $article)
    {

        try {
            $article->update(['active' => !$article['active']]);
            return response(new ArticleResource($article), 200);
        } catch (\Exception $exception) {
//            return response($exception->getMessage(), (integer)$exception->getCode());
            return response([$exception->getMessage(), (integer)$exception->getCode()], 500);
        }
    }
}

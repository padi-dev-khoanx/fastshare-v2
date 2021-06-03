<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Text;
use Illuminate\View\View;

class TextController extends Controller
{
    /**
     * @return View
     */
    public function index()
    {
        return view('text/index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submit(Request $request)
    {
        $data = [];
        $data['title'] = $request->get('title');
        $data['content'] = $request->get('summary-ckeditor');
        $data['text_path'] = '';
        $dataCreated = Text::create($data);
        $textPath = trim(base64_encode(str_pad($dataCreated->id, 6, '.')), '=');

        $data['text_path'] = $textPath;
        $query = Text::find($dataCreated->id);
        $query['text_path'] = $textPath;
        $query->save();

        return response()->json(['text_path'=> $request->root() . '/text/' . $textPath, 'id' => $dataCreated->id]);
    }

    public function show($path)
    {
        $idFile = trim(base64_decode($path), '.');
        $text = Text::find($idFile);
        return view('text/show', compact('text'));
    }
}

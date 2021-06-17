<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Text;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
     * @return JsonResponse
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:50',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'failed',
                    'msg'=> $validator->errors()
                ]
            );
        }

        $data = [];
        $data['title'] = $request->get('title');
        $data['content'] = $request->get('content');
        $data['text_path'] = '';
        if (Auth::user()) {
            $data['user_id'] = Auth::user()->id;
        }

        $dataCreated = Text::create($data);
        $textPath = trim(base64_encode(str_pad($dataCreated->id, 6, '.')), '=');

        $data['text_path'] = $textPath;
        $query = Text::find($dataCreated->id);
        $query['text_path'] = $textPath;
        $query->save();

        return response()->json(
            [
                'status' => 'success',
                'text_path' => $request->root() . '/text/' . $textPath,
                'id' => $dataCreated->id
            ]
        );
    }

    /**
     * @param $path
     * @return Application|Factory|View
     */
    public function show($path)
    {
        $idFile = trim(base64_decode($path), '.');
        $text = Text::find($idFile);
        return view('text/show', compact('text'));
    }

    public function delete($id)
    {
        $text = Text::find($id);
        if ($text->user_id == Auth::user()->id) {
            $text->delete();
            return redirect()->back()->with('success', 'Xóa văn bản chia sẻ thành công');
        } else {
            return redirect()->back()->withErrors(['Bạn không có quyền xóa văn bản của người khác']);
        }
    }
}

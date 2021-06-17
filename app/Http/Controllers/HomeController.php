<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileUpload;
use Carbon\Carbon;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response as FacadeResponse;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    public function upload(Request $request)
    {
        $now = strtotime(Carbon::now());
        foreach ($request->file('file') as $fileKey => $fileObject ) {
            $data['name'] = $fileObject->getClientOriginalName();
            $data['type'] = $fileObject->getClientOriginalExtension();
            $data['size'] = $fileObject->getSize();
            $data['path'] = $fileObject->move('upload', $data['name'].$now);
            $data['day_exist'] = 1;
            if (Auth::user()) {
                $data['user_id'] = Auth::user()->id;
                if (Auth::user()->type_user == 1) {
                    $data['day_exist'] = 7;
                }
            }
            $data['path_download'] = '';
            $dataCreated = FileUpload::create($data);

            $path_download = trim(base64_encode(str_pad($dataCreated->id, 6, '.')), '=');

            $data['path_download'] = $path_download;
            $query = FileUpload::find($dataCreated->id);
            $query['path_download'] = $path_download;
            $query->save();
            return response()->json(['path_download'=> $request->root() . '/' . $path_download, 'id' => $dataCreated->id]);
        }
    }
    public function download($path)
    {
        $idFile = trim(base64_decode($path), '.');
        $file = FileUpload::find($idFile);
        $isExists = File::exists($file->path);
        return view('download', compact('file', 'isExists'));
    }
    public function preview($path)
    {
        $idFile = trim(base64_decode($path), '.');
        $file = FileUpload::find($idFile);
        if( in_array($file->type, ['jpg', 'JPG', 'png', 'PNG', 'jpeg', 'JPEG']) ) {
            return view('preview', compact('file'));
        } elseif ( in_array($file->type, ['pdf', 'PDF']) ) {
            $filename = $file->name;
            $path = public_path($file->path);
            return FacadeResponse::make(file_get_contents($path), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$filename.'"'
            ]);
        } elseif ( in_array($file->type, ['txt', 'TXT']) ) {
            $txtFile = file_get_contents(public_path($file->path));
            return view('preview', compact('file', 'txtFile'));
        } elseif( in_array($file->type, ['flv', 'mp4', 'm3u8', 'ts', '3gp', 'mov', 'avi', 'wmv', 'webm']) ) {
            return view('preview', compact('file'));
        }
    }
    public function downloadFile(Request $request)
    {
        $pathToFile = 'upload/' . substr($request->filePath,7);
        $name = $request->fileName;
        $file = FileUpload::find($request->fileId);
        $file['times_download'] = $file['times_download'] - 1;
        $file->save();
        if($file['times_download'] == 0) {
            return response()->download($pathToFile, $name)->deleteFileAfterSend(true);
        } else {
            return response()->download($pathToFile, $name);
        }
    }
    public function delete(Request $request)
    {
        $file = FileUpload::find($request['id']);
        File::delete($file->path);
        $file->delete();
    }

    public function updateTimesDownload(Request $request)
    {
        $file = FileUpload::find($request->id);
        $file['times_download'] = $request->times_download;
        $file->save();
        return response()->json(['success'=> true]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

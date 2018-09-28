<?php

namespace Pinkwhale\Jellyfish\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Pinkwhale\Jellyfish\Models\Media;
use Validator;
use Image;
use Storage;

class MediaController extends Controller {

    protected $info;
    protected $sizes = [
        'small'  => [400, 300],
        'medium' => [600, 400],
        'big'    => [800, 700],
    ];

    public function index($type=null) {
        $scope = (new Media)->orderBy('updated_at', 'desc');
        if($type != null){
            $scope = $scope->where('type',$type);
        }
        $this->info['list'] = $scope->get();
        $this->info['storage_size'] = $this->TotalStorage();
        $this->info['filter'] = $type;
        return view('jf::pages.media_list', $this->info);
    }

    public function index_files() { return $this->index('attachment'); }
    public function index_pictures() { return $this->index('picture'); }

    public function show($id) {

        $this->info['data'] = [];
        $this->info['fileID'] = $id;

        return view('jf::pages.media_show', $this->info);
    }

    public function store($id) {

        Validator::make(request()->all(), [
            'title' => 'required',
            'file'  => 'required',
        ])->validate();

        $file = (new Media);
        $file->title = request()->title;

        if ( in_array(request()->file->extension(), ['jpg', 'jpeg', 'png']) ) {
            $file->type = 'picture';
            $file->filename = request()->file->hashName();
            foreach ( $this->sizes as $sKey => $size ) {
                $img = Image::make(request()->file)->resize($size[0], null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $path = 'pictures/' . $sKey . '_' . $file->filename;
                Storage::put($path, (string) $img->encode());
            }

            // Check if file below needed quality.
            if(Image::make(request()->file)->width() < $this->sizes['big'][0] || Image::make(request()->file)->height() < $this->sizes['big'][1]){
                $file->alert  = true;
            }

        } else {

            $file->type = 'attachment';
            $filename = request()->file('file')->store(
                'files'
            );
            $file->filename = str_replace('files/', '', $filename);
        }
        $file->save();

        return redirect()->route('jelly-media')->with(['message' => ['state' => 'success', 'message' => 'Upload afgerond!']]);
    }

    public function displayCustomImage($id){

        $expl = explode('.',$id);
        $file = (new Media)->where('id', $expl[0])->where('type', 'picture')->first();

        if($file != null && Storage::exists('pictures/big_'.$file->filename))
            $path = storage_path('app/pictures/big_'.$file->filename);
        else
            $path = str_replace('/Controllers', null, __DIR__) . '/assets/default_images/mimes/_blank.png';

        // Build Image.
        $img = Image::make($path);

        if(isset(request()->fit) && count(explode('x',request()->fit)) > 1){
            $sizes = explode('x',request()->fit);
            $img->fit($sizes[0], $sizes[1], function ($constraint) {
                $constraint->upsize();
            });
        }

        // Change size (canvas) when requested.
        if(isset(request()->size) && count(explode('x',request()->size)) > 1){
            $sizes = explode('x',request()->size);
            $img->resize($sizes[0], null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->resizeCanvas($sizes[0], $sizes[1], 'center',false);
        }

        return $img->response();
    }

    /**
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function displayFile($id){
        $file = (new Media)->where('id', $id)->where('type', 'attachment')->first();
        if ( !Storage::exists('files/' . $file->filename) ) {
          abort(404, 'File not found!');
        }

        // Return also with slugified title + extension.
        return response()->download(storage_path('app/files/'.$file->filename),$file->title.'.'.explode('.',$file->filename)[1]);
    }

    /**
     * @param $filename
     *
     * @return mixed
     */
    public function displayPicture($filename) {
        $strip = explode('_', $filename);

        if ( $strip[0] != 'file' ) {
            $file = (new Media)->where('filename', $strip[1])->where('type', 'picture')->first();
            if ( $file == null ) $filename = 'noimage.png';
            if ( !Storage::exists('pictures/' . $filename) ) {
                abort(404, 'File not found!');
            }
            $img = Image::make(Storage::get('pictures/' . $filename));
        } else {
            $file = (new Media)->where('filename', $strip[1])->where('type', 'attachment')->first();
            if ( !Storage::exists('files/' . $strip[1]) ) {
                abort(404, 'File not found!');
            }
            if ( $file == null ) $filename = 'noimage.png';

            $mimes = str_replace('/Controllers', null, __DIR__) . '/assets/default_images/mimes';
            $type = explode('/', Storage::mimeType('files/' . $strip[1]))[1];
            $file_to_open = $mimes . '/' . $type . '.png';;
            if ( file_exists($file_to_open) ) $img = Image::make($file_to_open);
            else $img = Image::make($mimes . '/_blank.png');

            $img = $img->greyscale();
        }

        return $img->response();
    }

    public function download($id) {

        $file = (new Media)->where('id', $id)->firstOrFail();
        if ( $file->type == 'attachment' && Storage::exists('files/' . $file->filename) ) {
            return response()->download(storage_path('app/files/') . $file->filename);
        } else {
            $img = Image::make(Storage::get('pictures/big_' . $file->filename));

            return $img->response();
        }


    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function destroy($id) {

        $file = (new Media)->where('id', $id)->firstOrFail();
        if ( $file->type == 'attachment' && Storage::exists('files/' . $file->filename) ) {
            Storage::delete('files/' . $file->filename);
            $file->delete();
        } else {
            Storage::delete('pictures/small_' . $file->filename);
            Storage::delete('pictures/medium_' . $file->filename);
            Storage::delete('pictures/big_' . $file->filename);
            $file->delete();
        }

        return redirect()->route('jelly-media')->with(['message' => ['state' => 'success', 'message' => 'verwijderd!']]);
    }

    public function TotalStorage() {

        $file_size = 0;
        if ( Storage::exists('pictures') )
            foreach ( Storage::allFiles('pictures') as $pic )
                $file_size += Storage::size($pic);

        if ( Storage::exists('files') )
            foreach ( Storage::allFiles('files') as $file )
                $file_size += Storage::size($file);

        return $this->formatBytes($file_size);
    }

    private function formatBytes($size, $precision = 2) {
        $base = log($size, 1024);
        $suffixes = ['', 'K', 'M', 'G', 'T'];

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }

}

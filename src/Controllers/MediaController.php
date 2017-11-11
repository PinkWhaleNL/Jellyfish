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

    public function index() {
        $this->info['list'] = (new Media)->orderBy('updated_at', 'desc')->get();

        return view('jf::pages.media_list', $this->info);
    }

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
        } else {

            $file->type = 'attachment';
            $filename = request()->file('file')->store(
                'files', 'app'
            );
            $file->filename = str_replace('files/', '', $filename);
        }
        $file->save();

        return redirect()->route('jelly-media')->with(['message'=>'OK!']);
    }

}

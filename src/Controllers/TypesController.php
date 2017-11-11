<?php

namespace Pinkwhale\Jellyfish\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Pinkwhale\Jellyfish\Models\Content;
use Pinkwhale\Jellyfish\Models\Types;
use Validator;

class TypesController extends Controller
{
    protected $info;

    /**
     * @param $type
     *
     * @return mixed
     */
    public function index($type){
        $this->info['data'] = (new Types)->where('type',$type)->firstOrFail();
        $this->info['documents'] = (new Content)->where('type',$type)->orderBy('updated_at','desc')->get();
        return view('jf::pages.types',$this->info);
    }

    public function show($type,$id){
        $this->info['data'] = (new Types)->where('type',$type)->first();
        $this->info['content'] = 'bami';
        return view('jf::pages.type',$this->info);
    }
    public function store($type,$id){

        // Validate all input.
        Validator::make(request()->all(),(new Types)->GetValidationRules($type))->validate();

        $fields = request()->all();
        unset($fields['_token']);

        $content = (new Content);
        $content->type = $type;
        $content->data = json_encode($fields);
        $content->save();

        return redirect()->route('jelly-modules',[$type])->with(['message'=>['state'=>'success','message'=>'Opgeslagen!']]);
    }

}

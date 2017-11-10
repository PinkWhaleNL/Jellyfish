<?php

namespace Pinkwhale\Jellyfish\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Pinkwhale\Jellyfish\Models\Types;

class AdminController extends Controller
{
    protected $info;
    public function redirect(){
        return redirect()->route('jelly-admin-types');
    }
    public function index_types(){
        $this->info['types'] = (new Types)->all();
        return view('jf::pages.admin.types',$this->info);
    }
    public function show_type($id){
        $this->info['data'] = ($id != 'new'?(new Types)->where('id',$id)->firstOrFail():[]);
        return view('jf::pages.admin.type',$this->info);
    }
    public function store_type($id){

        if(!(new Types)->isJson(request()->json)){
            return back()->withInput();
        }

        $type = ($id != 'new'?(new Types)->where('id',$id)->firstOrFail():(new Types));
        $type->type = str_slug(request()->type);
        $type->data = request()->json;
        $type->save();

        return redirect()->route('jelly-admin-types');
    }

    public function destroy_type($id){
        (new Types)->where('id',$id)->delete();
        return redirect()->route('jelly-admin-types');
    }
}
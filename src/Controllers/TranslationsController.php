<?php

namespace Pinkwhale\Jellyfish\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Pinkwhale\Jellyfish\Models\Pages;
use Pinkwhale\Jellyfish\Models\Translations;
use Validator;

class TranslationsController extends Controller {

    protected $info;

    public function index(){

        $this->info['pages'] = (new Pages)->orderBy('title','desc')->get();
        return view('jf::pages.translation_pages',$this->info);

    }

    public function create(){
        return view('jf::pages.translation_page_create');
    }

    public function show($id){
        $this->info['page'] = (new Pages)->where('id',$id)->firstOrFail();
        $this->info['rows'] = (new Translations)->orderBy('id','desc')->where('page_id',$id)->get();
        return view('jf::pages.translation_page_edit',$this->info);
    }


    public function store(){
        Validator::make(request()->all(),[
            'title' => 'required',
            'key' => 'required|unique:jelly_translation_pages,key'
        ])->validate();

        $page = (new Pages);
        $page->title = request()->title;
        $page->key = strtolower(request()->key);
        $page->save();

        return redirect()->route('jelly-translations')->with(['message'=>['state'=>'success','message'=>'Pagina opgeslagen']]);
    }

    public function store_item($id){

        if($id == 'new') {
            Validator::make(request()->all(),[
                'key'=>'required|unique:jelly_translations,key',
                'page_id' => 'required|exists:jelly_translation_pages,id'
            ])->validate();

            $item = (new Translations);
            $item->key = strtolower(str_slug(request()->key));
            $item->page_id = request()->page_id;
            $item->data = json_encode([]);
            $item->save();
        } else{

            $item = (new Translations)->where('id',$id)->firstOrFail();
            $item->data = json_encode(request()->data);
            $item->save();
        }

        return redirect()->back()->with(['message'=>['state'=>'success','message'=>'Vertaling opgeslagen']]);


    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy_item($id){
        (new Translations)->where('id',$id)->delete();
        return redirect()->back()->with(['message'=>['state'=>'success','message'=>'Verwijderd!']]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id){
        (new Translations)->where('page_id',$id)->delete();
        (new Pages)->where('id',$id)->delete();
        return redirect()->back()->with(['message'=>['state'=>'success','message'=>'Pagina + vertalingen verwijderd!']]);
    }


}

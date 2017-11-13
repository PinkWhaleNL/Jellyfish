<?php

namespace Pinkwhale\Jellyfish\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Pinkwhale\Jellyfish\Models\Pages;
use Pinkwhale\Jellyfish\Models\Translations;
use Validator;
use JellyAuth;

class TranslationsController extends Controller {

    protected $info;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $this->info['pages'] = (new Pages)->orderBy('title', 'desc')->get();

        return view('jf::pages.translation_pages', $this->info);

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        if(!JellyAuth::IsAdmin()){ abort(403); }
        return view('jf::pages.translation_page_create');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id) {



        $this->info['page'] = (new Pages)->where('id', $id)->firstOrFail();
        $this->info['rows'] = (new Translations)->orderBy('id', 'desc')->where('page_id', $id)->get();

        return view('jf::pages.translation_page_edit', $this->info);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store() {

        if(!JellyAuth::IsAdmin()){ abort(403); }

        Validator::make(request()->all(), [
            'title' => 'required',
            'key'   => 'required|unique:jelly_translation_pages,key',
        ])->validate();

        $page = (new Pages);
        $page->title = request()->title;
        $page->key = strtolower(request()->key);
        $page->save();

        return redirect()->route('jelly-translations')->with(['message' => ['state' => 'success', 'message' => 'Pagina opgeslagen']]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store_item($id) {

        if ( $id == 'new' ) {
            $validator = Validator::make(request()->all(), [
                'key'     => 'required',
                'page_id' => 'required|exists:jelly_translation_pages,id',
            ]);

            $validator->after(function ($validator) {
                if((new Translations)->where('key',request()->key)->where('page_id',request()->page_id)->first() != null){
                    $validator->errors()->add('key', 'Deze sleutel bestond al op deze pagina.');
                }
            });

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $item = (new Translations);
            $item->key = strtolower(str_slug(request()->key));
            $item->page_id = request()->page_id;
            $item->data = json_encode([]);
            $item->save();
        } else {

            $item = (new Translations)->where('id', $id)->firstOrFail();
            $item->data = json_encode(request()->data);
            $item->save();
        }

        return redirect()->back()->with(['alert' => ['state' => 'success', 'message' => 'Vertaling opgeslagen']]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy_item($id) {
        (new Translations)->where('id', $id)->delete();

        return redirect()->back()->with(['message' => ['state' => 'success', 'message' => 'Verwijderd!']]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id) {
        (new Translations)->where('page_id', $id)->delete();
        (new Pages)->where('id', $id)->delete();

        return redirect()->back()->with(['message' => ['state' => 'success', 'message' => 'Pagina + vertalingen verwijderd!']]);
    }


}

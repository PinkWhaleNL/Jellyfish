<?php

namespace Pinkwhale\Jellyfish\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Pinkwhale\Jellyfish\Models\Types;
use Pinkwhale\Jellyfish\Models\Content;
use Pinkwhale\Jellyfish\Models\Users;
use Illuminate\Validation\Rule;
use Validator;
use Hash;
use Pinkwhale\Jellyfish\Models\Preferences;
use JellyForms;

class AdminController extends Controller
{
    protected $info;

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        return redirect()->route('jelly-admin-types');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index_types()
    {
        $this->info['types'] = (new Types)->all();
        return view('jf::pages.admin.types', $this->info);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show_type($id)
    {
        $this->info['data'] = ($id != 'new'?(new Types)->where('id', $id)->firstOrFail():[]);
        return view('jf::pages.admin.type', $this->info);
    }

    /**
     * @param $id
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store_type($id)
    {
        if (!(new Types)->isJson(request()->json)) {
            return back()->withInput();
        }

        $type = ($id != 'new'?(new Types)->where('id', $id)->firstOrFail():(new Types));
        $type->sortable = (request()->sortable === 'true'? true: false);
        $type->publish_date = (request()->publish_date === 'true'? true: false);
        $type->type = str_slug(request()->type);
        $type->title = request()->title;
        $type->data = json_decode(request()->json);
        $type->save();

        return redirect()->route('jelly-admin-types');
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy_type($id)
    {
        $type = (new Types)->where('id', $id)->first();
        (new Content)->where('type', $type->type)->delete();
        $type->delete();
        return redirect()->route('jelly-admin-types');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list_users()
    {
        $this->info['users'] = (new Users)->get();
        return view('jf::pages.admin.users', $this->info);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show_user($id)
    {
        $this->info['user'] = [];
        if ($id != 'new') {
            $this->info['user'] = (new Users)->where('id', $id)->first();
        }
        return view('jf::pages.admin.user', $this->info);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store_user($id)
    {
        if ($id == 'new') {
            Validator::make(request()->all(), [
                'name' => 'required',
                'rank' => 'required',
                'email' => 'required|email|unique:jelly_users,email',
                'password' => 'required',
            ])->validate();
        } else {
            Validator::make(request()->all(), [
                'name' => 'required',
                'rank' => 'required',
                'email' => [
                    'required',
                    Rule::unique('jelly_users')->ignore($id),
                ],
            ])->validate();
        }

        $user = ($id != 'new' ? (new Users)->where('id', $id)->firstOrFail() : (new Users));
        $user->name = request()->name;
        $user->email = request()->email;
        $user->rank = request()->rank;

        if ($id == 'new' || isset(request()->password)) {
            $user->password = Hash::make(request()->password);
        }

        $user->save();

        return redirect()->route('jelly-admin-users')->with(['message' => ['state' => 'success', 'message' => 'Gebruiker is ' . ($id=='new'?'aangemaakt.':'aangepast.')]]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy_user($id)
    {
        (new Users)->where('id', $id)->delete();
        return redirect()->route('jelly-admin-users')->with(['message' => ['state' => 'success', 'message' => 'Gebruiker is verwijderd!']]);
    }


    /**
     * Preferences view for Admin's
     *
     * @return void
     */
    public function show_preferences()
    {
        $this->info['preferences'] = [];
        foreach ((new Preferences)->get() as $value) {
            $this->info['preferences'][strtolower($value->key)] = $value->data;
        }
        
        return view('jf::pages.admin.preferences', $this->info);
    }

    /**
     * Save key based preferences.
     *
     * @return void
     */
    public function store_preferences()
    {
        $data = request()->all();
        unset($data['_token']);

        foreach ($data as $key=>$item) {
            $q = (new Preferences);

            // Check if entity exists.
            $q = ($q->where('key', strtoupper($key))->count()>0?$q->where('key', strtoupper($key))->first():$q);
            $q->key = strtoupper($key);
            $q->data = $item;
            $q->save();
        }

        return redirect()->route('jelly-admin-preferences')->with(['message' => ['state' => 'success', 'message' => 'Opgeslagen']]);
    }
}

<?php

namespace Pinkwhale\Jellyfish\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Pinkwhale\Jellyfish\Models\Forms;
use Pinkwhale\Jellyfish\Models\Preferences;

class FormsController extends Controller
{
    protected $info;

    /**
     * List all filled forms.
     *
     * @return void
     */
    public function index()
    {
        $this->info['sms'] = (new Preferences)->where('key', 'SMS')->first();
        $this->info['list'] = (new Forms)->get();
        return view('jf::pages.forms', $this->info);
    }

    /**
     * Show form information.
     *
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {
        $this->info['form'] = (new Forms)->where('id', $id)->firstOrFail();
        return view('jf::pages.form', $this->info);
    }
}

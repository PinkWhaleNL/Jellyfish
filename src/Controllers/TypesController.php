<?php

namespace Pinkwhale\Jellyfish\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Pinkwhale\Jellyfish\Models\Content;
use Pinkwhale\Jellyfish\Models\Types;
use Validator;
use Carbon;

class TypesController extends Controller
{
    protected $info;

    /**
     * @param $type
     *
     * @return mixed
     */
    public function index($type)
    {
        $this->info['data'] = (new Types)->where('type', $type)->firstOrFail();
        $this->info['documents'] = (new Content)->where('type', $type)->orderBy('updated_at', 'desc')->get();

        return view('jf::pages.types', $this->info);
    }

    public function show($type, $id)
    {
        $this->info['data'] = (new Types)->where('type', $type)->first();
        $this->info['db'] = null;
        $this->info['row'] = null;

        if ($id != 'new') {
            $content = (new Content)->where('type', $type)->where('id', $id)->firstOrFail();
            $this->info['row'] = $content;
            $this->info['db'] = (array) $content->data;
        }

        return view('jf::pages.type', $this->info);
    }

    public function store($type, $id)
    {

        // Validate all input.
        Validator::make(request()->all(), (new Types)->GetValidationRules($type))->validate();

        $fields = request()->all();
        unset($fields['_token']);

        $content = ($id != 'new' ? (new Content)->where('type', $type)->where('id', $id)->firstOrFail() : (new Content));

        if (request()->sort) {
            $content->sort = (int)request()->sort;
        }
        if (request()->published_at) {
            $content->published_at = Carbon::parse(request()->published_at);
        }

        $content->type = $type;
        $content->data = $fields;
        $content->save();

        return redirect()->route('jelly-modules', [$type])->with(['message' => ['state' => 'success', 'message' => 'Opgeslagen!']]);
    }

    public function destroy($type, $id)
    {
        (new Content)->where('type', $type)->where('id', $id)->delete();

        return redirect()->route('jelly-modules', [$type])->with(['message' => ['state' => 'success', 'message' => 'Verwijderd']]);
    }
}

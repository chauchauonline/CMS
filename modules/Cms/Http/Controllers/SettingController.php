<?php
namespace Modules\Cms\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Setting;
use Illuminate\Support\Facades\Config;

class SettingController extends Controller
{
    public function index()
    {
        $setting_variables = Config::get('constants.SETTING_VARIABLES');
        return View::make('cms::settings.index', compact('setting_variables'));
    }

    public function edit($key)
    {
        $value = Setting::get($key);
        $setting_variables = Config::get('constants.SETTING_VARIABLES');
        return View::make('cms::settings.edit', compact('key', 'value', 'setting_variables'));
    }

    public function update( Request $request, $key)
    {
        $this->validate($request, [
                'value' => 'required',
        ]);
        $data = $request->all();
        Setting::set($key, $data['value']);
        Setting::save();
        return redirect('settings')->withSuccess(Lang::get('cms::message.update_setting_success'));
    }
}

<?php namespace Modules\Cms\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Modules\Cms\Entities\TotalFund;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\Lang;

class TotalFundController extends Controller
{
    public function edit()
    {
        $total_fund = TotalFund::first();
        if($total_fund) {
            return view('cms::total_fund.edit', compact('total_fund'));
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
                'total'  => 'required|numeric|min:0|digits_between:1,15',
        ]);
        $data = $request->all();
        $total_fund = TotalFund::find($id);
        if($total_fund->update($data)) {
            return redirect('funds')->withSuccess(Lang::get('cms::message.update_total_fund_success'));
        } else {
            return Redirect::back()->withInput()->withErrors(Lang::get('cms::message.update_total_fund_fail'));
        }
    }
}
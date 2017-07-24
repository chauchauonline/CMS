<?php namespace Modules\Cms\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Modules\Cms\Entities\Fund;
use Modules\Cms\Entities\FundMember;
use Modules\Cms\Entities\TotalFund;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Redirect;
use DB;

class FundMemberController extends Controller {
    public function update(Request $request) {
        $data = $request->all();
        $pay_in = $request->get('pay_in');
        $fund_id = $request->get('fund_id');
        $member_id = $request->get('member_id');
        $fund = Fund::find($fund_id);
        $amount = $fund->amount;
        $total_fund = TotalFund::first();
        $fund_member = FundMember::where('fund_id', '=', $fund_id)->where('member_id', '=', $member_id)->first();
        $change = false;
        if($pay_in == '1') { // Đã đóng
            if(!$fund_member) { // Chưa đóng -> đã đóng
                $new_fund_member = FundMember::create($data);
                if($new_fund_member){
                    $total_fund->total += $amount;
                    if($total_fund->save()){
                        $change = true;
                    }
                }
            } else {
                if($fund_member->update($data)) {
                    $change = true;
                }
            }
        } else {
            if($fund_member){  // Đã đóng->chưa đóng
                if($fund_member->delete()) {
                    $total_fund->total -= $amount;
                    if($total_fund->save()) {
                        $change = true;
                    }
                }
            } else {
                return Redirect::back()->withSuccess('Thay đổi thành công');
            }
        }
        if($change) {
            return Redirect::back()->withSuccess('Thay đổi thành công');
        } else {
            return Redirect::back()->withErrors('Đã xảy ra lỗi. Thay đổi không thành công');
        }
    }

    public function find(Request $request)
    {
        $fund_id = $request->get('fund_id');
        $member_id = $request->get('member_id');
        $fund_member = FundMember::where('fund_id', '=', $fund_id)->where('member_id', '=', $member_id)->first();
        if($fund_member) {
             return response()->json([ 'result' => 'ok', 'data' => ['fund_member' => $fund_member] ]);
        } else {
            return response()->json([ 'result' => 'ok', 'data' => [] ]);
        }
    }

    public function history(Request $request)
    {
        $member_id = $request->get('member_id');
        $records_per_page = Config::get('constants.RECORD_PER_PAGE');
        $funds_member = DB::table('funds_members as fm')
                            ->where('fm.deleted_at', '=', null)
                            ->where('fm.member_id', '=', $member_id)
                            ->leftjoin('fund as f', 'fm.fund_id', '=', 'f.id')
                            ->select('fm.*', 'f.type', 'f.content', 'f.amount', 'f.date')
                            ->paginate($records_per_page);
        $fund_types = Config::get('constants.FUND_TYPE');
        return view('cms::funds.history', compact('funds_member', 'fund_types'));
    }
}
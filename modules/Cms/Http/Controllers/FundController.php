<?php namespace Modules\Cms\Http\Controllers;

use Pingpong\Modules\Routing\Controller;
use Modules\Cms\Entities\Fund;
use Modules\Cms\Entities\FundMember;
use Modules\Cms\Entities\TotalFund;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Redirect;
use Illuminate\Support\Facades\Lang;
use Helpers;
use Modules\Cms\Entities\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use DB;

class FundController extends Controller
{
    public function index(Request $request)
    {
        // Tìm kiếm
        $type = $request->get('type');
        $content = $request->get('content');
        $records_per_page = Config::get('constants.RECORD_PER_PAGE', 20);
        if($content || $type != ''){
            $funds  = DB::table('fund')
                            ->where('deleted_at', '=', null)
                            ->Where(function($query) use ($type, $content) {
                                if($type != '') {
                                    $query->where('type', '=', $type);
                                }
                                if($content){
                                    $query->Where('content', 'LIKE', "%".trim($content)."%");
                                }
                            })
                            ->orderBy('created_at', 'DESC')
                            ->paginate($records_per_page);
            $funds->appends(['type' => $type, 'content' => $content]);
        } else {
            $funds = Fund::orderBy('created_at', 'DESC')->paginate($records_per_page);
        }
        $fund_types = Config::get('constants.FUND_TYPE');
        $total_fund = TotalFund::first();
        if($total_fund) {
            $remain_fund = $total_fund->total;
        } else {
            $remain_fund = 0;
        }
        $current_user = Sentinel::getUser();
        return view('cms::funds.index',compact('funds', 'fund_types', 'remain_fund', 'current_user'));
    }

    public function create()
    {
        $fund_types = Config::get('constants.FUND_TYPE');
        return view('cms::funds.create',compact('fund_types'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
                'content' => 'required',
                'amount'  => 'required|numeric|min:0|digits_between:1,15',
        ]);
        $data = $request->all();
        $data['date'] = Helpers::formatDateYmd($data['date']);
        // Nếu là khoản chi->kiểm tra tổng số tiền quỹ còn lại
        $save = false;
        if($data['type'] == '1') {
            $enough = TotalFund::compare_with_remain_fund($data['amount']);
            if(!$enough) {
                return Redirect::back()->withInput()->withErrors(Lang::get('cms::message.not_enough_fund'));
            } else {
                $fund = Fund::create($data);
                if($fund){
                    TotalFund::update_total_fund($data['amount'], '1');
                    $save = true;
                }
            }
        } else {
            $fund = Fund::create($data);
            if($fund) {
                $save = true;
            }
        }
        if($save){
            return redirect('funds')->withSuccess(Lang::get('cms::message.create_fund_success'));
        } else {
            return redirect('funds')->withSuccess(Lang::get('cms::message.create_fund_success'));
        }
    }

    public function show(Request $request, $id)
    {
        $fund = Fund::find($id);
        if($fund) {
            $fund_types = Config::get('constants.FUND_TYPE');
            $status = Config::get('constants.PAY_IN_STATUS');
            if($fund->type == '0') { // Nếu là khoản thu, hiển thị danh sách hội viên và trạng thái đóng tiền
                $records_per_page = Config::get('constants.RECORD_PER_PAGE', 20);
                $keyword  = $request->get('keyword');
                if($keyword) {
                    $members = User::orWhere(DB::raw('CONCAT(last_name, " ", first_name)'), 'like', "%".trim($keyword)."%")
                                    ->orWhere('email', 'LIKE', "%".trim($keyword)."%")
                                    ->orWhere('mobile', 'LIKE', "%".trim($keyword)."%")
                                    ->orderBy('first_name', 'ASC')->paginate($records_per_page);
                    $members->appends(['keyword' => $keyword]);
                } else {
                    $members = User::orderBy('first_name', 'ASC')->paginate($records_per_page);
                }
                $fund_members = FundMember::where('fund_id', '=', $id)->select('member_id', 'note')->get();
            } else {  // Nếu là khoản chi, hiển thị nội dung khoản chi
                $members = null;
                $fund_members = null;
            }
            $current_user = Sentinel::getUser();
            return View::make('cms::funds.show', compact('fund', 'fund_types', 'members', 'fund_members','status', 'current_user'));
        } else {
             return redirect('funds')->withErrors(Lang::get('cms::message.fund_not_found'));
        }
    }

    public function edit($id)
    {
        if($fund = Fund::find($id)){
            $fund_types = Config::get('constants.FUND_TYPE');
            return view('cms::funds.edit', compact('fund', 'fund_types'));
        }
        return redirect('funds')->withErrors(Lang::get('cms::message.fund_not_found'));

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
                'content' => 'required',
                'amount'  => 'required|numeric|min:0|digits_between:1,15',
        ]);
        $data = $request->all();
        $data['date'] = Helpers::formatDateYmd($data['date']);
        $fund = Fund::find($id);
        $update = false;
        // So sánh số tiền thay đổi so với lúc trước
        $amount_before = $fund->amount;
        if($amount_before > $data['amount']) { // Số tiền cập nhật nhỏ hơn trước
            if($fund->type == '1') {// Khoản chi
                $change = $amount_before - $data['amount'];
                TotalFund::update_total_fund($change, '0');
                if($fund->update($data)) {
                    $update = true;
                }
            } else { // Khoản thu
                if($fund->update($data)) {
                    $update = true;
                }
            }
        } else { // Số tiền cập nhật lớn hơn trước
            if($fund->type == '1') { // Khoản chi
                $change = $data['amount'] - $amount_before;
                $enough = TotalFund::compare_with_remain_fund($change);
                if(!$enough) {
                    return Redirect::back()->withInput()->withErrors(Lang::get('cms::message.not_enough_fund'));
                } else {
                    TotalFund::update_total_fund($change, '1');
                    if($fund->update($data)) {
                        $update = true;
                    }
                }
            } else {
                if($fund->update($data)) {
                    $update = true;
                }
            }
        }
        if($update) {
            return redirect('funds')->withSuccess(Lang::get('cms::message.update_fund_success'));
        } else {
            return Redirect::back()->withInput()->withErrors(Lang::get('cms::message.update_fund_fail'));
        }

    }

    public function delete(Request $request)
    {
        $id = $request->get('id');
        $fund = Fund::find($id);
        $delete = false;
        if($fund) {
            $type = $fund->type;
            if($type == '0') { // Khoản thu, không cho xóa nếu đã/đang thu tiền
                $fund_members = FundMember::where('fund_id', '=', $id)->count();
                if($fund_members > 0 ){
                    return Redirect::back()->withInput()->withErrors(Lang::get('cms::message.not_allow_to_delete'));
                } else {
                    if($fund->delete()){
                        $delete = true;
                    }
                }
            } else { // Khoản chi -> cộng lại quỹ tổng
                $amount = $fund->amount;
                if($fund->delete()){
                    $delete = true;
                    TotalFund::update_total_fund($amount, '0');
                }
            }
            if($delete) {
                return Redirect::back()->withInput()->withSuccess(Lang::get('cms::message.delete_fund_success'));
            } else {
                return Redirect::back()->withInput()->withErrors(Lang::get('cms::message.delete_fund_fail'));
            }
        } else {
            return redirect('funds')->withErrors(Lang::get('cms::message.fund_not_found'));
        }
    }
}
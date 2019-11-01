<?php

namespace App\Http\Controllers;

// use App\Permission;
// use App\User;

use Illuminate\Http\Request;
use App\Models\{Querymodel, Store, Campaign};
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('store.list');
    }

    public function get_list(Request $req)
    {
        $in     = $req->input();
        $output = array(
            "iTotalRecords" => 0, 
            "iTotalDisplayRecords" => 0, 
            "data" => array(), 
            "download_link" => "", 
            "resp" => ""
        );

        $data_filter = $req['data_filter'];
        $column      = [
            'id'                        => 'ad.id',
            'advertiser_id'             => 'ad.advertiser_id',
            'short_name'                => 'ad.short_name',
            'full_name'                 => 'ad.full_name',
            'domain_name'               => 'ad.domain_name',
            'default_user_commision'    => 'ad.default_user_commision',
            'user_commission_type'      => 'ad.user_commission_type',
            'status'                    => 'ad.status',
            'referral_validity'         => 'ad.referral_validity',
            'created_at'                => 'ad.created_at',
            'updated_at'                => 'ad.updated_at',
        ];
        $cols = [];

        foreach ($column AS $k => $v) {
            $cols[] = $v . ' AS ' . $k;
        }
        $ptable = 'advertisers as ad ';

        $where = '';
        $order = '';
        if (isset($req['search'])) {
            if ($in['search']['value'] != '') {
                $search = '';
                foreach ($in['columns'] as $c) {
                    if (is_array($c['data'])) {
                        $c['data'] = @$c['data']['_'];
                    }
                    $dd        = explode(".", $c['data']);
                    $c['data'] = $dd[0];
                    if (array_key_exists($c['data'], $column)) {
                        $search .= $search == '' ? ' (' : ' OR ';
                        if ($in['search']['regex'] == 'true') {
                            $search .= $column[$c['data']] . " REGEXP '" . $in['search']['value'] . "' ";
                        } else {
                            $search .= $column[$c['data']] . " LIKE '%" . $in['search']['value'] . "%' ";
                        }
                    }
                }

                if ($search != '') {
                    $search .= ')';
                    $where .= ($where == '' ? ' WHERE ' : ' AND ') . $search;
                }
            }
        }

        if (isset($in['order'])) {
            foreach (@$in['order'] as $odr) {
                $_odr = '';
                $i    = $odr['column'];
                if ($in['columns'][$i]['orderable']) {
                    if (is_array($in['columns'][$i]['data'])) {
                        $in['columns'][$i]['data'] = @$in['columns'][$i]['data']['_'];
                    }
                    $_col = $in['columns'][$i]['data'];
                    if (array_key_exists($_col, $column)) {
                        // $_odr .= ($_odr != '' ? ' , ': '') . $column[$_col] .' '. $odr['dir'];
                        $_odr .= ($_odr != '' ? ' , ' : '') . $_col . ' ' . $odr['dir'];
                    }
                }
                if ($_odr != '') {
                    $order = ($order == '' ? ' ORDER BY ' : ' , ') . $_odr;
                }
            }
        }
        $stable = '';
        $param  = [
            'db'      => 'read',
            'pcolumn' => $column['id'],
            'ptable'  => $ptable,
            'stable'  => $stable,
            'column'  => $cols,
            'order'   => $order,
            'where'   => $where,
            'limit'   => '',
        ];

        $QM = new Querymodel('deposit_history');

        $resp = $QM->countTxn($param);

        $output["iTotalRecords"]        = $QM->countTxn($param);
        $param["where"]                 = $where;
        $param['limit']                 = ' LIMIT ' . $req['start'] . ',' . $req['length'];
        $result                         = $QM->getTxns($param);
        $output["iTotalDisplayRecords"] = $output["iTotalRecords"];

        !$result && $result = [];
        foreach ($result as $res) {
            $res->DT_RowClass = 'success';
            $res->DT_RowId    = $res->id;
            $res->created_at  = date('d M Y H:i a', strtotime($res->created_at));
            $res->updated_at  = date('d M Y H:i a', strtotime($res->updated_at));
            $output['data'][] = $res;
        }

        die(json_encode($output));
    }

    public function changeStoreStatus(Request $req)
    {
        $data = $req->input();
        // $user = \Auth::user();
        $error = false;

        if(!$data['id']){
            die(json_encode(['status'=>'201','msg'=>'Something went wrong!']));
        }

        if(!in_array($data['status'], ['Enable','Disable'])){
            die(json_encode(['status'=>'201','msg'=>'Something went wrong!']));
        }

        $status = '0';
        if($data['status'] == 'Enable'){
            $status = 1;
        }

        $storeData = Store::where('advertiser_id',$data['id'])->first();
        $storeData->status = $status;
        $storeData->save();

        die(json_encode(['status'=>'200','msg'=>'Store '.$data['status'].'d successfuly']));
    }

    public function get_detail($uid = false)
    {
        if(!$uid) return abort(404);
        $this->user = \Auth::user();
        $data['store_data'] = Store::where('advertiser_id',$uid)->first();

        if(!$data['store_data']) return abort(404);
        
        return view('store.detail',$data);
    }

    public function campaign_list(Request $req)
    {
        $in     = $req->input();
        $output = array(
            "iTotalRecords" => 0, 
            "iTotalDisplayRecords" => 0, 
            "data" => array(), 
            "download_link" => "", 
            "resp" => ""
        );

        $data_filter = $req['data_filter'];
        $column      = [
            'id'                        => 'camp.id',
            'campaign_id'               => 'camp.campaign_id',
            'advertiser_id'             => 'camp.advertiser_id',
            'name'                      => 'camp.name',
            'country_id'                => 'camp.country_id',
            'utm_link'                  => 'camp.utm_link',
            'min_discount'              => 'camp.min_discount',
            'max_discount'              => 'camp.max_discount',
            'start_date'                => 'camp.start_date',
            'end_date'                  => 'camp.end_date',
            'status'                    => 'camp.status',
            'created_at'                => 'camp.created_at',
            'short_name'                => 'ad.short_name',
        ];
        $cols = [];

        foreach ($column AS $k => $v) {
            $cols[] = $v . ' AS ' . $k;
        }
        $ptable = 'campaigns as camp JOIN advertisers as ad on camp.advertiser_id = ad.advertiser_id ';
        // $ptable = 'orders as o ';

        $where = "";

        if(isset($in['adid'])){
            
            $where .= " where ad.advertiser_id = '".$in['adid']."'";
        }

        $order = '';
        if (isset($req['search'])) {
            if ($in['search']['value'] != '') {
                $search = '';
                foreach ($in['columns'] as $c) {
                    if (is_array($c['data'])) {
                        $c['data'] = @$c['data']['_'];
                    }
                    $dd        = explode(".", $c['data']);
                    $c['data'] = $dd[0];
                    if (array_key_exists($c['data'], $column)) {
                        $search .= $search == '' ? ' (' : ' OR ';
                        if ($in['search']['regex'] == 'true') {
                            $search .= $column[$c['data']] . " REGEXP '" . $in['search']['value'] . "' ";
                        } else {
                            $search .= $column[$c['data']] . " LIKE '%" . $in['search']['value'] . "%' ";
                        }
                    }
                }

                if ($search != '') {
                    $search .= ')';
                    $where .= ($where == '' ? ' WHERE ' : ' AND ') . $search;
                }
            }
        }

        if (isset($in['order'])) {
            foreach (@$in['order'] as $odr) {
                $_odr = '';
                $i    = $odr['column'];
                if ($in['columns'][$i]['orderable']) {
                    if (is_array($in['columns'][$i]['data'])) {
                        $in['columns'][$i]['data'] = @$in['columns'][$i]['data']['_'];
                    }
                    $_col = $in['columns'][$i]['data'];
                    if (array_key_exists($_col, $column)) {
                        // $_odr .= ($_odr != '' ? ' , ': '') . $column[$_col] .' '. $odr['dir'];
                        $_odr .= ($_odr != '' ? ' , ' : '') . $_col . ' ' . $odr['dir'];
                    }
                }
                if ($_odr != '') {
                    $order = ($order == '' ? ' ORDER BY ' : ' , ') . $_odr;
                }
            }
        }
        $stable = '';
        $param  = [
            'db'      => 'read',
            'pcolumn' => $column['id'],
            'ptable'  => $ptable,
            'stable'  => $stable,
            'column'  => $cols,
            'order'   => $order,
            'where'   => $where,
            'limit'   => '',
        ];

        $QM = new Querymodel('deposit_history');

        $resp = $QM->countTxn($param);

        $output["iTotalRecords"]        = $QM->countTxn($param);
        $param["where"]                 = $where;
        $param['limit']                 = ' LIMIT ' . $req['start'] . ',' . $req['length'];
        $result                         = $QM->getTxns($param);
        $output["iTotalDisplayRecords"] = $output["iTotalRecords"];

        !$result && $result = [];
        foreach ($result as $res) {
            $res->DT_RowClass = 'success';
            $res->DT_RowId    = $res->id;
            $res->start_date  = date('d M Y', strtotime($res->start_date));
            $res->end_date  = date('d M Y', strtotime($res->end_date));
            $res->created_at  = date('d M Y H:i a', strtotime($res->created_at));
            $output['data'][] = $res;
        }

        die(json_encode($output));
    }

    public function changeCampaignStatus(Request $req)
    {
        $data = $req->input();
        // $user = \Auth::user();
        $error = false;

        if(!$data['id']){
            die(json_encode(['status'=>'201','msg'=>'Something went wrong!']));
        }

        if(!in_array($data['status'], ['Enable','Disable'])){
            die(json_encode(['status'=>'201','msg'=>'Something went wrong!']));
        }

        $status = '0';
        if($data['status'] == 'Enable'){
            $status = 1;
        }

        $storeData = Campaign::where('campaign_id',$data['id'])->first();
        $storeData->status = $status;
        $storeData->save();

        die(json_encode(['status'=>'200','msg'=>'Campaign '.$data['status'].'d successfuly']));
    }

    public function getFormHtml(Request $req)
    {
        $input = $req->input();

        $data = [];
        if(!empty($input['id'])){
            $data['store_data'] = Store::where('advertiser_id',$input['id'])->first();

            if(!$data['store_data']) return abort(404);
        }
        return view('store.form',$data);
    }

    public function updateStore(Request $req)
    {
        $data = $req->input();
        $error = false;

        if(!$data['store_id']){
            die(json_encode(['status'=>'202','msg'=>'Something went wrong!']));
        }

        if(!$data['short_name']){
            $error = true;
            $error_msg[] = 'short_name';
        }

        if(!$data['full_name']){
            $error = true;
            $error_msg[] = 'full_name';
        }

        if(!$data['domain_name']){
            $error = true;
            $error_msg[] = 'domain_name';
        }

        if(!$data['default_user_commision']){
            $error = true;
            $error_msg[] = 'default_user_commision';
        }

        if(!$data['referral_validity']){
            $error = true;
            $error_msg[] = 'referral_validity';
        }

        if($error){
            die(json_encode(['status'=>'201','msg'=>$error_msg]));
        }

        $store_id = $data['store_id'];
        unset($data['_token']);
        unset($data['store_id']);
        $data['updated_at'] = date('y-m-d H:i:s');

        Store::where('advertiser_id',$store_id)->update($data);

        die(json_encode(['status'=>'200','msg'=>'Store data updated successfuly']));
    }

    public function createNew(Request $req)
    {
        $data = $req->input();
        $error = false;
        
        if(!$data['short_name']){
            $error = true;
            $error_msg[] = 'short_name';
        }

        if(!$data['full_name']){
            $error = true;
            $error_msg[] = 'full_name';
        }

        if(!$data['domain_name']){
            $error = true;
            $error_msg[] = 'domain_name';
        }

        if(!$data['default_user_commision']){
            $error = true;
            $error_msg[] = 'default_user_commision';
        }

        if(!$data['referral_validity']){
            $error = true;
            $error_msg[] = 'referral_validity';
        }

        if($error){
            die(json_encode(['status'=>'201','msg'=>$error_msg]));
        }

        unset($data['_token']);
        unset($data['store_id']);
        $data['advertiser_id'] = getUniqueId(10);

        Store::insert($data);

        die(json_encode(['status'=>'200','msg'=>'Store created successfuly']));
    }

    public function getCampaignFormHtml(Request $req)
    {
        $input = $req->input();

        $data = [
            'store_id'=> $input['store_id']
        ];
        if(!empty($input['id'])){
            $data['camp_data'] = Campaign::where('campaign_id',$input['id'])->first();

            if(!$data['camp_data']) return abort(404);
        }
        return view('store.campaign_form',$data);
    }

    public function updateCampaign(Request $req)
    {
        $data = $req->input();
        $error = false;

        if(!$data['campaign_id']){
            die(json_encode(['status'=>'202','msg'=>'Something went wrong!']));
        }

        if(!$data['name']){
            $error = true;
            $error_msg[] = 'name';
        }

        if(!$data['utm_link']){
            $error = true;
            $error_msg[] = 'utm_link';
        }

        if(!$data['min_discount']){
            $error = true;
            $error_msg[] = 'min_discount';
        }

        if(!$data['max_discount']){
            $error = true;
            $error_msg[] = 'max_discount';
        }

        if($error){
            die(json_encode(['status'=>'201','msg'=>$error_msg]));
        }

        $campaign_id = $data['campaign_id'];
        unset($data['_token']);
        unset($data['campaign_id']);
        unset($data['advertiser_id']);
        $data['updated_at'] = date('y-m-d H:i:s');

        Campaign::where('campaign_id',$campaign_id)->update($data);

        die(json_encode(['status'=>'200','msg'=>'Campaign data updated successfuly']));
    }

    public function createNewCampaign(Request $req)
    {
        $data = $req->input();
        $error = false;
        
        if(!$data['name']){
            $error = true;
            $error_msg[] = 'name';
        }

        if(!$data['utm_link']){
            $error = true;
            $error_msg[] = 'utm_link';
        }

        if(!$data['min_discount']){
            $error = true;
            $error_msg[] = 'min_discount';
        }

        if(!$data['max_discount']){
            $error = true;
            $error_msg[] = 'max_discount';
        }

        if($error){
            die(json_encode(['status'=>'201','msg'=>$error_msg]));
        }

        unset($data['_token']);
        unset($data['campaign_id']);
        $data['campaign_id'] = getUniqueId(10);

        Campaign::insert($data);

        die(json_encode(['status'=>'200','msg'=>'Campaign created successfuly']));
    }
}

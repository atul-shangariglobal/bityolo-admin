<?php

namespace App\Http\Controllers;

// use App\Permission;
// use App\User;

use Illuminate\Http\Request;
use App\Models\{Querymodel};
use Illuminate\Support\Facades\DB;

class ReferralController extends Controller
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
        return view('referrals');
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
            'id'                    => 'rh.id',
            'referrer_first_name'   => 'cust1.first_name',
            'referrer_last_name'    => 'cust1.last_name',
            'referrer_unique_id'    => 'cust1.unique_id',
            'user_first_name'       => 'cust2.first_name',
            'user_last_name'        => 'cust2.last_name',
            'user_unique_id'        => 'cust2.unique_id',
            'created_at'            => 'rh.created_at',
        ];
        $cols = [];

        foreach ($column AS $k => $v) {
            $cols[] = $v . ' AS ' . $k;
        }
        $ptable = 'referral_history as rh JOIN customers as cust1 on rh.referrer_id = cust1.id JOIN customers as cust2 on user_unique_id = cust2.id';

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
            $output['data'][] = $res;
        }

        die(json_encode($output));
    }
}

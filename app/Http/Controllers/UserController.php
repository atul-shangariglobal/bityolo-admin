<?php

namespace App\Http\Controllers;

use App\Permission;
use App\User;
use Illuminate\Http\Request;
use App\Models\{Querymodel};

class UserController extends Controller
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
        return view('user.list');
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
            'id'                => 'u.id',
            'name'              => 'u.name',
            'email'             => 'u.email',
            'created_at'        => 'u.created_at',
            'updated_at'        => 'u.updated_at',
        ];
        $cols = [];

        foreach ($column AS $k => $v) {
            $cols[] = $v . ' AS ' . $k;
        }
        $ptable = 'users as u ';

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
}

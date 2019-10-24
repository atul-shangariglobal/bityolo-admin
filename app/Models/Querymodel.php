<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Querymodel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = '';

    protected $fillable = [
        'user_id', 'type','log','created_at',
    ];

    public $timestamps = false;
    public function __construct($table =''){
       $this->table = $table;
    }



    public function countTxn($param = false){
    // Validate Requiere param
    if( ! $param || ! isset($param['ptable']) || $param['ptable'] == '' || ! isset($param['pcolumn']) || $param['pcolumn'] == ''){
        return false;
    }

    // Optional Params
    $where = "";
    if(isset($param['where']))
    {
        $where	= $param['where'];
    }

    // Create a Query
    if(isset($param['stable']) && $param['stable'] != ''){
        $in = explode(".",$param['pcolumn']);
        if(isset($in[1]))
            $in = $in[1];
        else
            $in = $param['pcolumn'];
        $sql = "SELECT COUNT(DISTINCT(cc." . $in . ")) AS foundRows FROM (SELECT " . $param["pcolumn"] . " FROM " . $param["ptable"] . " " . $where . " UNION ALL SELECT " . $param["pcolumn"] ." FROM " . $param["stable"] . " " . $where . ") AS cc";
    }
    else{
        $sql = "SELECT COUNT(DISTINCT(" . $param["pcolumn"] . ")) as foundRows FROM ". $param["ptable"] . " " . $where;
    }
        if(isset($param['group']) && $param['group'] != '')
        {
            $sql.= $param['group'];
        }
        $result= \DB::select($sql);

    if(count($result)>0 && isset($result[0]->foundRows)){
        return $result[0]->foundRows;
    }
    else{
        return 0;
    }
}
    public function getTxns($param = false){
        // Validate Requiere param
        if( ! $param || ! isset($param['ptable']) || $param['ptable'] == '') {
            return false;
        }

        // Optional Params
        $column	= "*";
        $where	= "";
        $order	= "";
        $limit	= "";
        $group	= "";

        if(isset($param['column']) && is_array($param['column']) && !empty($param['column'])){
            $column	= str_replace(" , ", " ", implode(", ", $param['column']));
        }

        if(isset($param['where']) && $param['where'] != ''){
            $where	= $param['where'];
        }

        if(isset($param['order']) && $param['order'] != '')
        {
            $order	= $param['order'];
        }

        if(isset($param['limit']) && $param['limit'] != '')
        {
            $limit	= $param['limit'];
        }

        if(isset($param['group']) && $param['group'] != '')
        {
            $group	= $param['group'];
        }

        // Create a Query
        $sql	= "SELECT " . $column;
        $sql	.= " FROM " . $param['ptable'] . " " . $where;

        if(isset($param['stable']) && $param['stable'] != '')
        {
            $sql .= " UNION ALL SELECT " . $column . " FROM ". $param['stable'] . " " . $where;
        }


        $sql .= " " . $group . " " . $order . " " . $limit;

        $result= \DB::select($sql);


        if($result){
            return $result;
           /* if($query->num_rows() >0)
            {
                return $query->result();
            }
            else
            {
                return false;
            }*/
        }
        else
        {
            return false;
        }
    }

}

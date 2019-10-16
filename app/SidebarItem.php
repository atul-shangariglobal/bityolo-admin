<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SidebarItem extends Model
{
    use SoftDeletes;

    protected $table = 'sidebaritems';

}

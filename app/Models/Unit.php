<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'tbl_mg_units'; // предполагаемое имя таблицы в SQL Server
    protected $primaryKey = 'unit_id';
}

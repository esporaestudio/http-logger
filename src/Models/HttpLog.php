<?php

namespace Espora\HttpLogger\Models;

use Illuminate\Database\Eloquent\Model;

class HttpLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip',
        'url',
        'method',
        'req_header',
        'req_body',
        'res_header',
        'res_body',
    ];
}

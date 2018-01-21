<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static $this select(array $fieldset = null)
 * @method $this where($what, $how, $which = null)
 * @method $this first()
 * @method \arrayObject get()
 */
class Rate extends Model
{
    protected $fillable = [
        'cc',
        'r030',
        'rate',
        'exchangedate',
    ];

}

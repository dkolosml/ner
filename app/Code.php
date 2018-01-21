<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static $this select(array $fieldset = null)
 * @method $this where($what, $how, $which = null)
 * @method $this first()
 * @method get()
 */
class Code extends Model
{
    protected $fillable = [
        'r030',
        'txt',
        'cc',
    ];

}

<?php /* ner app */

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static $this select(array $fieldset = null)
 * @method $this where($what, $how, $which = null)
 * @method $this first()
 */
class Date extends Model
{
    protected $fillable = [
        'date',
    ];

}

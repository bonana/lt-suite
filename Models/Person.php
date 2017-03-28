<?php
/**
 * Class to represent people from BankID.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Models
 */

namespace Livetime\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'people';

    public function signatures()
    {
        return $this->hasMany('Livetime\Models\Signature');
    }
}
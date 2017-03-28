<?php
/**
 * Class to represent BankID signatures.
 *
 * @link        http://livetime.nu
 * @since       1.0.0
 * @author      Alexander Karlsson <alexander@livetime.nu>
 * @package     LivetimeSuite
 * @subpackage  LivetimeSuite/Models
 */

namespace Livetime\Models;

use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    public function owner()
    {
        return $this->belongsTo('Livetime\Models\Person');
    }

    public function project()
    {
        return $this->belongsTo('Livetime\Models\Project');
    }
}
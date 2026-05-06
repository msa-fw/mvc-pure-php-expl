<?php

namespace Controllers\Home\Models;

use System\Core\Model;
use System\Core\Database\Builder;

/**
 * Class HomeModel
 * @package Controllers\Home\Models
 *
 * @method static|Builder Home()
 */
class HomeModel extends Model
{
    protected $table = 'Home';
}
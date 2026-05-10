<?php

namespace Controllers\Home\Models;

use System\Core\Model;

/**
 * Class HomeModel
 * @package Controllers\Home\Models
 *
 * @method static|self Home()
 */
class HomeModel extends Model
{
    public function test($id)
    {
        $statement = $this->build()->where("id = %id%", ['%id%' => $id])
            ->select('*');

        return $this->findOne($statement,'items');
    }
}
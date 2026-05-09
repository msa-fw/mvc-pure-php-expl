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

    public function test()
    {
        $query = $this->build()->select();

        $sql = $query->query();
        $cache = $this->cache->find($this->table, 'list');

        if($data = $cache->get($sql)){
            dbg('cache');
            return $this->collect($data);
        }

        if($data = $query->result()->all()){
            dbg('DB');
            $cache->set($sql, $data);
            return $this->collect($data);
        }

        return [];
    }
}
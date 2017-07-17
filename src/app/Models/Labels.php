<?php

/**
 * Created by PhpStorm.
 * User: Yury
 * Date: 02/07/2017
 * Time: 20:25
 */

namespace App\Models;
class Labels extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'labels';

    public function content(){

        return $this->hasOne('App\Models\ContentPage', 'foreign_key', 'id_label');
    }

}
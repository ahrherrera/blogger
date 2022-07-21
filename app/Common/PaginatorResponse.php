<?php

namespace App\Common;


class PaginatorResponse
{
    public $data = null;

    public $count = 0;

    public function populate($data){
        $this->data = $data->data;
        $this->count = $data->count;
    }

}

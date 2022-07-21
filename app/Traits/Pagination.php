<?php

namespace App\Traits;


use App\Common\PaginatorResponse;

trait Pagination
{

    public function getPagination($query, $page, $pageSize, $orderKey = null, $orderType = null, $getArgs = null)
    {
        if (!empty($page) && !empty($pageSize)) {
            $skip = ($page - 1) * $pageSize;
            $count = $query->count();
            $data = $query->skip($skip)->take($pageSize);

            if ($orderKey != null) {
                $data->orderBy($orderKey, $orderType);
            }

            if ($getArgs) {
                $data = $data->select($getArgs)->get();
            } else {
                $data = $data->get();
            }
            $results = new PaginatorResponse();
            $results->data = $data;
            $results->count = $count;

            return $results;
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

}

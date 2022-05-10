<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{


    public function getAllList();

    public function find($id);

    public function store($data);

    public function update($id, $data);

    public function destroy($id);

    public function paginate();
}

?>

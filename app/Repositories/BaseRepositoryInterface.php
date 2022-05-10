<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{

    public function getAllList();

    public function getListById($id);

    public function store($data);

    public function update($id, $data);

    public function destroy($id);

    public function paginate();
}

?>

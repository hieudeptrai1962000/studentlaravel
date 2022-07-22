<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{


    public function getAll();

    public function find($id);

    public function store($data);

    public function update($id, $data);

    public function destroy($id);

    public function paginate();

    public function findBySlug($slug);

    public function checkEmail($email);

    public function query();
}

?>

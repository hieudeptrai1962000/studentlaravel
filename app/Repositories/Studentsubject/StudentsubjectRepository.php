<?php
namespace App\Repositories\Studentsubject;

use App\Models\Studentsubject\Studentsubject;
use App\Repositories\BaseRepository;

class StudentsubjectRepository extends BaseRepository implements StudentsubjectRepositoryInterface
{

    public function __construct(Studentsubject $studentsubject)
    {
        parent::__construct($studentsubject);
    }

    public function query() {
        return $this->model->query();
    }
}


?>

<?php
namespace App\Repositories\Student;

use App\Models\Student\Student;
use App\Repositories\BaseRepository;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface
{

    public function __construct(Student $student)
    {
        parent::__construct($student);
    }

    public function query() {
        return $this->model->query();
    }
}

?>

<?php
namespace App\Repositories\Subject;

use App\Models\Subject\Subject;
use App\Repositories\BaseRepository;

class SubjectRepository extends BaseRepository implements SubjectRepositoryInterface
{

    public function __construct(Subject $subject)
    {
        parent::__construct($subject);
    }
}

?>

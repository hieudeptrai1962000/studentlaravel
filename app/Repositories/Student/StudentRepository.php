<?php
namespace App\Repositories\Student;

use App\Models\Student\Student;
use App\Models\Subject\Subject;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface
{

    public function __construct(Student $student)
    {
        parent::__construct($student);
    }

    public function query()
    {
        return $this->model->query();
    }

    public function search($data)
    {
        $students = $this->model->with('stu');
        $count = Subject::all()->count();


        //AGE
        if (isset($data['max_age']) && isset($data['max_age'])) {
            $min = Carbon::now()->subYears($data['min_age']);
            $max = Carbon::now()->subYears($data['max_age']);
            $students->whereBetween('birthday', [$max, $min]);
        }
        if (!empty($data['min_age'])) {
            $min = Carbon::now()->subYears($data['min_age']);
            $students->where('birthday', '<=', $min);
        }

        if (!empty($data['max_age'])) {
            $max = Carbon::now()->subYears($data['max_age']);
            $students->where('birthday', '>=', $max);
        }

        if (!empty($data['subject_id'])) {
            $students->whereHas('mark', function ($query) use ($data) {
                $query->where('subject_id', $data['subject_id']);
            });
        }

        //MARK
        if (!empty($data['min_mark'])) {
            $students->whereHas('mark', function ($query) use ($data) {
                if (!empty($data['subject_id'])) {
                    $query = $query->where('subject_id', $data['subject_id']);
                }

                $query->where('mark', '>=', $data['min_mark']);
            });
        }

        if (!empty($data['max_mark'])) {
            $students->whereHas('mark', function ($query) use ($data) {
                if (!empty($data['subject_id'])) {
                    $query = $query->where('subject_id', $data['subject_id']);
                }

                $query->where('mark', '<=', $data['max_mark']);
            });
        }


        //DONE

        if (!empty($data['done']) && empty($data['not_done'])) {
            $students->whereHas('stu', function ($query) {
                $query->where('mark', '>', 0);
            }, '=', $count);
        }

        if (!empty($data['not_done']) && empty($data['done'])) {
            $students->has('stu', '<', $count);
        }

        //PHONE
        if (!empty($data['phoneviettel'])) {
            $students->where(function ($query) use ($data) {
                $query->where('phone_number', 'regexp', '096');
            });
        }
        if (!empty($data['phonevina'])) {
            $students->where(function ($query) use ($data) {
                $query->where('phone_number', 'regexp', '083');
            });
        }
        if (!empty($data['phonemobi'])) {
            $students->where(function ($query) use ($data) {
                $query->where('phone_number', 'regexp', '0123');
            });
        }

        //AVG < 5
        if (!empty($data['less_5']) && empty($data['greater_5'])) {

            $students->has('stu', '=', $count)
                ->whereHas('mark', function ($query) {
                    $query->havingRaw('AVG(mark) < 5');
                });
        }
        if (!empty($data['greater_5']) && empty($data['less_5'])) {

            $students->has('stu', '=', $count)
                ->whereHas('mark', function ($query) {
                    $query->havingRaw('AVG(mark) >= 5');
                });
        }

        return $students->paginate(5);
    }

    public function chickenStudent()
    {
        $students = $this->model->with('stu');
        $count = Subject::all()->count();
        $students->has('stu', '=', $count)
            ->whereHas('mark', function ($query) {
                $query->havingRaw('AVG(mark) < 5');
            });

        return $students->paginate();
    }
}

?>

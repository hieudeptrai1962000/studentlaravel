<?php
namespace App\Repositories\Student;

use App\Models\Student\Student;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface
{

    public function __construct(Student $student)
    {
        parent::__construct($student);
    }

    public function search($data, $subjectCount)
    {
        $students = $this->model->with('students');

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
                    $query->where('subject_id', $data['subject_id']);
                }

                $query->where('mark', '>=', $data['min_mark']);
            });
        }

        if (!empty($data['max_mark'])) {
            $students->whereHas('mark', function ($query) use ($data) {
                if (!empty($data['subject_id'])) {
                    $query->where('subject_id', $data['subject_id']);
                }

                $query->where('mark', '<=', $data['max_mark']);
            });
        }

        if (!empty($data['learn_status']) && $data['learn_status'] == 'finished') {
            $students->whereHas('students', function ($query) {
                $query->where('mark', '>', 0);
            }, '=', $subjectCount);
        }
        if (!empty($data['learn_status']) && $data['learn_status'] == 'unfinished') {
            $students->has('students', '<', $subjectCount);
        }

        //PHONE
        $phones = [
            'viettel' => '^096|^097',
            'vina' => '^083',
            'mobi' => '^0123',
        ];

        if (!empty($data['viettel']) || !empty($data['vina']) || !empty($data['mobi'])) {
            $students->where(function ($query) use ($data, $phones) {
                foreach ($phones as $field => $phone) {
                    if (!empty($data[$field])) {
                        $query->orWhere('phone_number', 'regexp', $phone);
                    }
                }
            });
        }

        return $students->paginate(5);
    }

    public function chickenStudent($count)
    {
        $students = $this->model->with('students');
        $students->has('students', '=', $count)
            ->whereHas('mark', function ($query) {
                $query->havingRaw('AVG(mark) < 5');
            });

        return $students->get();
    }
}

?>

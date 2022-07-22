<?php
namespace App\Repositories\Users;
use App\Models\User;
use App\Repositories\BaseRepository;
class UsersRepository extends BaseRepository implements UsersRepositoryInterface {
    protected $users;
    public function __construct(User $users){
        parent::__construct($users);
    }

}
?>

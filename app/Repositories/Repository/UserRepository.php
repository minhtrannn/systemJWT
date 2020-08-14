<?php 

namespace App\Repositories\Repository;

use App\Repositories\RepositoryInterface\RepositoryInterface;
use App\User;

class UserRepository implements RepositoryInterface
{

    public function getAll()
    {

    }

    public function getSingle($id)
    {
        return User::whereId($id)->first();
    }

    public function find($id)
    {

    }

    public function create(array $attributes)
    {

    }

    public function update($id, array $attributes)
    {

    }

    public function delete($id)
    {

    }

    public function updateUserInfor(array $attributes)
    {
        $id = auth()->user()->id;
        $result = User::find($id);
        if($result)
        {
            $result->update($attributes);
            return $result;
        }
        return false;
    }

}
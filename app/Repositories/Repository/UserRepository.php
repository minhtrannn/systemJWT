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

    public function store(array $attributes)
    {
        $user = new User();
        $user->name = $attributes->name;
        $user->email = $attributes->email;
        $user->password = $attributes->password;
        $user->save();
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
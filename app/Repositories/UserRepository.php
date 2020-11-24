<?php 

namespace App\Repositories;

use App\Model\User;

class UserRepository extends BaseRepository
{

    const MODEL = User::class;

    // public function getAll()
    // {

    // }

    // public function getSingle($id)
    // {
    //     return User::whereId($id)->first();
    // }

    // public function find($id)
    // {

    // }

    // public function store(array $attributes)
    // {
    //     $user = new User();
    //     $user->name = $attributes->name;
    //     $user->email = $attributes->email;
    //     $user->password = $attributes->password;
    //     $user->save();
    // }

    // public function update($id, array $attributes)
    // {

    // }

    // public function delete($id)
    // {

    // }

    // public function updateUserInfor(array $attributes)
    // {
    //     $id = auth()->user()->id;
    //     $result = User::find($id);
    //     if($result)
    //     {
    //         $result->update($attributes);
    //         return $result;
    //     }
    //     return false;
    // }

}
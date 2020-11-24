<?php 

namespace App\Repositories\Repository;

use App\Repositories\RepositoryInterface\RepositoryInterface;
use App\Model\Post;


class PostRepository extends BaseRepository 
{

    const MODEL = POST::class;
    // public function getAll()
    // {
    //     return Post::orderBy('id', 'asc')->get();
    // }

    // public function getSingle($id)
    // {
    //     return Post::whereId($id)->first();
    // }

    // public function find($id)
    // {
    //     return Post::find($id);
    // }

    // public function create(array $attributes)
    // {
    //     $post = new Post();
    //     // return Post::create($attribute);
    //     return $post->create($attributes);
    // }

    // public function update($id, array $attributes)
    // {
    //     $result = Post::find($id);
    //     if ($result) {
    //         $result->update($attributes);
    //         return $result;
    //     }
    //     return false;
    // }

    // public function delete($id)
    // {
    //     $result = $this->find($id);
    //     if ($result) {
    //         $result->delete();
    //         return true;
    //     }
    //     return false;
    // }
}
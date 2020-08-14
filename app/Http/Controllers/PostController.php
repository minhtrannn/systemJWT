<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Repository\PostRepository;
class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAllPost()
    {
        if(!auth()->user())
        {
            return response()->json(['Message' => 'Not Authorized']);
        }
        else 
        {
            $post = $this->postRepository->getAll();
            return response()->json($post);
        }
    }

    public function getSingle($id)
    {
        if(!auth()->user())
        {
            return response()->json(['Message' => 'Not Authorized']);
        }
        else 
        {
            $post = $this->postRepository->find($id);
            if($post == null)
            {
                return response()->json(['Message' => "This page doesn't exist"]);
            }
            else 
            {
                $post = $this->postRepository->getSingle($id);
                return response()->json($post);
            }
        }
    }

    public function createPost()
    {
        if(!auth()->user())
        {
            return response()->json(['Message' => 'Not Authorized']);
        }
        else 
        {
            $post = request(['title','body']);
            $data = array(
                'title' => request('title'),
                'body' => request('body'),
                'user_id' => auth()->user()->id,
            );
            $postCreated = $this->postRepository->create($data);
            if($postCreated)
            {
                return response()->json($postCreated);
            }
            else 
            {
                return response()->json(['Message' => 'Cannot create post']);
            }
        }
    }

    public function updatePost($id)
    {
        if(!auth()->user())
        {
            return response()->json(['Message' => 'Not Authorized']);
        }
        else 
        {
            $post = array(
                'title' => request('title'),
                'body' => request('body'),
                'user_id' => auth()->user()->id,
            );
            $postUpdated = $this->postRepository->update($id,$post);
            if($postUpdated)
            {
                return response()->json($postUpdated);
            }
            else 
            {
                return response()->json(['Message' => 'Cannot update post']);
            }
        }
    }

    public function deletePost($id)
    {
        if(!auth()->user())
        {
            return response()->json(['Message' => 'Not Authorized']);
        }
        else 
        {
            $postDeleted = $this->postRepository->delete($id);
            if($postDeleted)
            {
                return response()->json(['Message' => 'Deleted Successful']);
            }
            else 
            {
                return response()->json(['Message' => 'Cannot delete post']);
            }
        }
    }

    
}

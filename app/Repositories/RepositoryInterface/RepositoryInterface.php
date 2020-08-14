<?php 

namespace App\Repositories\RepositoryInterface;

interface RepositoryInterface 
{
    public function getAll();
    public function getSingle($id);
    public function find($id);
    public function create(array $attributes);
    public function update($id, array $attributes);
    public function delete($id);
}
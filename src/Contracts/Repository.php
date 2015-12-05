<?php namespace Inneuron\Repository\Contracts;

interface Repository
{
    public function findAll();

    public function findAllWithPagination($pagination = null);

    public function findById($id);

    public function findByField($field, $value);

    public function create(array $data);

    public function update($entity, array $data);

    public function persist($entity);

    public function remove($entity);
}
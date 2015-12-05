<?php namespace Inneuron\Repository\Eloquent;

use Inneuron\Repository\Contracts\Repository;

abstract class BaseRepository implements Repository
{
    /**
     * Pagination
     */
    const PAGINATION = 20;

    /**
     * @var string
     */
    protected $model = null;

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $instance = null;

    /**
     * @var array Eager load other model
     */
    protected $with = [];

    /**
     * Repository constructor
     */
    public function __construct()
    {
        $this->createModelInstance();
    }

    /**
     * Instantiate model instance
     */
    protected function createModelInstance()
    {
        $modelClass = $this->model;

        if ($modelClass === null) {
            throw new \Exception('Repository model property is not specified.');
        }

        $this->instance = new $modelClass;

        if (!empty($this->with)) {
            $this->instance = $this->instance->with($this->with);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll()
    {
        return $this->instance->get();
    }

    /**
     * @param null $pagination
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findAllWithPagination($pagination = null)
    {
        $pagination = $pagination ?: self::PAGINATION;

        return $this->instance->paginate($pagination);
    }

    /**
     * @param $field
     * @param $value
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findByField($field, $value)
    {
        return $this->instance->where($field, $value)->get();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        $modelClass = $this->model;

        $entity = new $modelClass($data);

        return $this->persist($entity);
    }

    /**
     * @param $entity \Illuminate\Database\Eloquent\Model
     * @return mixed
     */
    public function persist($entity)
    {
        $entity->save();

        return $entity;
    }

    /**
     * @param $entity
     * @param array $data
     * @return bool|int
     */
    public function update($entity, array $data)
    {
        if (!$entity instanceof $this->model) {
            $entity = $this->findById($entity);
        }

        return $entity->update($data);;
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findById($id)
    {
        return $this->instance->find($id);
    }

    /**
     * @param $entity
     * @return bool|null
     * @throws \Exception
     */
    public function remove($entity)
    {
        if (!$entity instanceof $this->model) {
            $entity = $this->findById($entity);
        }

        return $entity->delete();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getInstance()
    {
        return $this->instance;
    }

    public function with($relations)
    {
        $this->instance = $this->instance->with($relations);

        return $this;
    }
}
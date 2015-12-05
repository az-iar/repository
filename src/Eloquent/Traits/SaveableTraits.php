<?php namespace Inneuron\Repository\Eloquent\Traits;

class SaveAbleTraits
{
    /**
     * @param $entity \Illuminate\Database\Eloquent\Model
     * @param array $data
     * @return mixed
     */
    public function save($entity, array $data)
    {
        $entity->fill($data);
        $entity->save();

        return $entity;
    }
}
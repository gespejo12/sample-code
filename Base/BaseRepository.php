<?php

namespace App\Base;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BaseRepository
 *
 * @package Modules\Core
 */
abstract class BaseRepository
{
    /**
     * @var BaseModel
     */
    private $model;

    /**
     * BaseRepository constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $model = $this->model();

        if (! $model instanceof Model) {
            $repositoryName = get_class($this);
            throw new Exception("{$repositoryName} provided model is invalid");
        }

        $this->model = $model;
    }

    /**
     * Get the repository model
     *
     * @return Model
     */
    abstract protected function model();

    /**
     * Find model or fail
     *
     * @param integer $id
     *
     * @return BaseModel
     */
    public function findOrFail($id)
    {
        $record = $this->findOrNull($id);

        if ($record === null) {
            throw new Exception("No record found on {$this->getModelName()} for [{$id}]");
        }

        return $record;
    }

    /**
     * Find model or null
     *
     * @param integer $id
     *
     * @return BaseModel|Model|null
     */
    public function findOrNull($id)
    {
        return $this->query()
            ->where('id', $id)
            ->first();
    }

    /**
     * Get name of the model class
     *
     * @return string
     */
    private function getModelName()
    {
        return get_class($this);
    }

    /**
     * Get new query
     *
     * @return Builder
     */
    public function query()
    {
        return $this->model->newQuery();
    }

    /**
     * Create a record
     *
     * @param array $inputs
     *
     * @return BaseModel|mixed
     */
    public function create($inputs)
    {
        return $this->model->create($inputs);
    }

    /**
     * Update a record
     *
     * @param Model $model
     * @param array $inputs
     *
     * @return BaseModel|Model
     */
    public function update(Model $model, $inputs)
    {
        $model->update($inputs);

        return $model->fresh();
    }

    /**
     * Update a collection of records
     *
     * @param Collection $collection
     * @param array $inputs
     *
     * @return Collection
     */
    public function batchUpdate(Collection $collection, array $inputs)
    {
        $this->query()
            ->whereIn('id', $collection->pluck('id'))
            ->update($inputs);

        return $collection->fresh();
    }

    /**
     * Delete a record
     *
     * @param BaseModel|Model $model
     *
     * @return bool
     */
    public function delete(Model $model)
    {
        $model->delete();

        return true;
    }

    /**
     * Find a record by a given parameters
     *
     * @param array $parameters
     * @return BaseModel|Model
     */
    public function findBy(array $parameters)
    {
        $query = $this->query();

        foreach ($parameters as $key => $value) {
            $query->where($key, $value);
        }

        return $query->first();
    }

    /**
     * Get a collection of records by id or fail
     *
     * @param array $ids
     * @throws Exception
     *
     * @return Collection $records
     */
    public function getByIdsOrFail(array $ids)
    {
        $records = $this->query()->whereIn('id', $ids)->get();

        if ($records->count() < count($ids)) {
            $nonExistingIds = array_diff($ids, $records->pluck('id')->toArray());

            throw new Exception('No records found for these ids. ['. implode(',', $nonExistingIds). ']');
        }

        return $records;
    }

    /**
     * Find by a given field or return null
     *
     * @param string g$field
     * @param string $value
     *
     * @return BaseModel|Model
     */
    public function findByOrNull($field, $value)
    {
        return $this->query()->where($field, $value)->first();
    }

    /**
     * Find by a given field or return null
     *
     * @param string g$field
     * @param string $value
     *
     * @return BaseModel|Model
     */
    public function findByOrFail($field, $value)
    {
        $record = $this->findByOrNull($field, $value);

        if ($record === null) {
            throw (new Exception())->setModel($this->model());
        }

        return $record;
    }

    /**
     * Get all records
     *
     * @return BaseModel[]|Model[]|Collection
     */
    public function all()
    {
        return $this->query()->get();
    }
}

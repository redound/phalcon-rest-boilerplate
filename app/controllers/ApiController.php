<?php

use App\Constants\Services as AppServices;
use PhalconRest\Constants\ErrorCodes as ErrorCodes;
use PhalconRest\Exceptions\UserException;

class ApiController extends \App\Mvc\Controller
{
    public function initResource($resourceKey)
    {
        /** @var \PhalconRest\Api\Resource $collection */
        $this->resource = $this->apiService->getResource($resourceKey);
        $model = $this->resource->getModel();
        $this->query->setModel($model);
    }

    public function fetchList($resourceKey)
    {
        $this->initResource($resourceKey);

        $transformer = $this->resource->getTransformer();

        // Get Query parse & it to phqlQuery
        $phqlBuilder = $this->phqlQueryParser->fromQuery($this->query);
        $results = $phqlBuilder->getQuery()->execute();

        return $this->respondCollection($results, new $transformer, $this->resource->getKey());
    }

    public function fetchSingle($resourceKey, $id)
    {
        $this->initResource($resourceKey);

        $transformer = $this->resource->getTransformer();

        // Get Query parse & it to phqlQuery
        $phqlBuilder = $this->phqlQueryParser->fromQuery($this->query);
        $results = $phqlBuilder->getQuery()->executeSingle();

        return $this->respondCollection($results, new $transformer, $this->resource->getKey());
    }

    public function create($resourceKey)
    {
        $data = (array)$this->request->getJsonRawBody();

    }

    public function update($resourceKey, $id)
    {
        $data = (array)$this->request->getJsonRawBody();

    }

    public function remove($resourceKey, $id)
    {

    }
}
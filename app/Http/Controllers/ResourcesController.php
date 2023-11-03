<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResourceRequest;
use App\Http\Resources\Resource;
use App\Http\Resources\Collection;
use App\Repositories\resourceRepository;
use Illuminate\Http\Request;

class ResourcesController extends Controller {
    private $resourceRepository;

    public function __construct(ResourceRepository $resourceRepository) {
        $this->resourceRepository = $resourceRepository;
    }

    public function index(Request $request){
        return new Collection($this->resourceRepository->paginate($request));
    }

    public function store(ResourceRequest $request){
        return new Resource($this->resourceRepository->add($request->all()));
    }

    public function show($id){
        return new Resource($this->resourceRepository->find($id));
    }

    public function update(ResourceRequest $request, $id){
        return new Resource($this->resourceRepository->update($request->all(), $id));
    }

    public function destroy($id){
        return new Resource($this->resourceRepository->destroy($id));
    }

}

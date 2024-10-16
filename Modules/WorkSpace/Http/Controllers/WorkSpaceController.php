<?php

namespace Modules\WorkSpace\Http\Controllers;

use Modules\WorkSpace\Service\WorkSpaceService;
use Illuminate\Routing\Controller;
use Modules\Image\Http\Requests\ImageRequest;
use Modules\WorkSpace\Http\Requests\WorkSpaceRequest;

class WorkSpaceController extends Controller
{
    private $service;
    public function __construct(WorkSpaceService $service) {

        $this->service = $service;
    }

    public function index() {
        return response()->json($this->service->index());
    }
    public function edit() {
        $id = auth('admin-api')->user()->work_space_id;
        return response()->json($this->service->edit($id));
    }
    public function show($id) {
        return response()->json($this->service->show($id));
    }

    public function update(WorkSpaceRequest $request) {
        return response()->json($this->service->update($request));
    }
    public function upload(ImageRequest $request) {
        return  response()->json(['id' => $this->service->upload($request)]);
    }

    public function delete($id) {
        $this->service->delete($id);
        return response()->json(['success' => 'success'],200);
    }
}

<?php 
namespace Modules\WorkSpace\Service;

use Exception;
use Modules\Image\Service\ImageService;
use Modules\WorkSpace\Models\WorkSpace;
class WorkSpaceService {

    private $path = 'workspace';
    public function index() {
        $image = new ImageService();
        $workSpaces = WorkSpace::with(['traffic:work_space_id,count,full'])
        ->JoinSub($image->getMainImage(),'mi',function($join) {
            $join->on('work_spaces.id','=','mi.work_space_id');
            })->get(['id','name','address','mi.path']);
        $image->iterateOnArrayOfObjectImage($workSpaces);
        foreach($workSpaces as $workSpace) {
            $this->unsetAttribute($workSpace->traffic);
        }
        
        return $workSpaces;
    }
    public function show($id) {

        $workSpace = WorkSpace::with(['traffic:work_space_id,count,full'])
        ->where('id',$id)->first();
        if(!$workSpace) throw new Exception('There is no workspace with id' .$id, 404);
        $image = new ImageService();
        $paths = $image->getImage($id);
        $workSpace->images = $paths;
        $AssociatedBranches = WorkSpace::with(['traffic:work_space_id,count,full'])
        ->LeftJoinSub($image->getMainImage(),'mi',function($join) {
            $join->on('work_spaces.id','=','mi.work_space_id');
            })
        ->where('company_id',$workSpace->company_id)
        ->where('id','!=',$id)
        ->get(['id','name','address','mi.path']);
        $workSpace->AssociatedBranches = $AssociatedBranches;
        $this->unsetAttribute($workSpace->traffic);
        unset($workSpace->company_id);
        return $workSpace;
    }
    private function unsetAttribute($traffic) {

        if(!$traffic) {
            return;
        }else {
            unset($traffic->work_space_id);
        }
    }
    public function edit($id) {

        $workSpace = WorkSpace::with(['traffic:work_space_id,full'])->where('id',$id)->first();
        if(!$workSpace) throw new Exception('There is no workspace with id' .$id, 404);
        $paths = (new ImageService())->getImage($id,1);
        $workSpace->images = $paths;
        $this->unsetAttribute($workSpace->traffic);
        unset($workSpace->company_id);
        return $workSpace;
    }


    public function update($request) {
        
        $workSpace = WorkSpace::findOrFail($request->id);
        $workSpace->update($request->safe()->except(['image_ids']));
        if($request->has('image_ids')) {
            $workSpace->images()->sync($request->image_ids);
            $paths = (new ImageService())->move($request->image_ids);
            $workSpace->images = $paths; 
        }
        
        return $workSpace;
    }

    public function upload($request) {
        return (new ImageService())->upload($request,$this->path);
    }

    public function delete($id) {

        (new ImageService())->deleteImage($id);
    }
}
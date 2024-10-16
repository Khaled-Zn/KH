<?php 
namespace Modules\Image\Service;
use Illuminate\Support\Facades\Storage;
use Modules\Image\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Modules\Image\Enums\ImageType;
use stdClass;

class ImageService {


    public function upload($request,$typeImage) {

        $path = Storage::putFileAs(
            'temp/' . $typeImage, $request->file('image'),$request->file('image')->hashName()
        );
        $imageId = Image::insertGetId([
            'path' => Str::after($path,'temp/'),
            'type_id' =>  $request->type
        ]);  
        return $imageId;
    }
    public function move($ids) {

        $images = Image::whereIn('id',$ids)->get(['id','path']);
        $newPath = null;
        foreach($images as $image) {
            $newPath = 'public/' . $image->path;
            Storage::move('temp/' . $image->path, $newPath);
        }
        $this->iterateOnArrayOfObjectImage($images);
        return $images;
    }

    public function getMainImage() {
        return DB::table('images as im')
        ->join('image_workspaces as iw', function ($join) {
            $join->on('im.id', '=', 'iw.image_id');
        })->where('im.type_id',ImageType::main->value)
        ->select('im.path','iw.work_space_id');
    }

    public function getImage($id,$edit = null) {

        $paths  = DB::table('images as im')
        ->join('image_workspaces as iw', function ($join) use($id) {
            $join->on('im.id', '=', 'iw.image_id')
                 ->where('iw.work_space_id',$id);
        });
        if(!$edit) {
            $paths = $paths->get(['im.path','im.type_id']);
            // $this->iterateOnArrayOfObjectImage($paths);
            $paths = $paths->groupBy('type_id');
            $pathsAfterCollecet = new stdClass;
            $pathsAfterCollecet->main = $paths['1'];
            $this->iterateOnArrayOfObjectImage($pathsAfterCollecet->main);
            unset($pathsAfterCollecet->main[0]->type_id);
            $pathsAfterCollecet->main = $pathsAfterCollecet->main[0];
            $pathsAfterCollecet->gallery = $paths['2'];
            $this->iterateOnArrayOfObjectImage($pathsAfterCollecet->gallery);
            foreach( $pathsAfterCollecet->gallery as $image){
                unset($image->type_id);
            }
            return $pathsAfterCollecet;
        }else {
            $paths = $paths->get(['im.id','im.path','im.type_id']);
            $this->iterateOnArrayOfObjectImage($paths);
        } 

        return $paths;
    }

    public function iterateOnArrayOfObjectImage($paths) {

        foreach($paths as $path) {
            $path->path = request()->root() . '/storage/' . $path->path;
        }
    }

    public function deleteImage($id) {

        $image = Image::findOrFail($id);
        $filePath = storage_path('app/public/'.$image->path);
        if (file_exists($filePath)) {
            Storage::delete('/public/' . $image->path);
            $image->delete();
        }
        else {
            Storage::delete('/temp/' . $image->path);
            $image->delete();
        }
    }

}
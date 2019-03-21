<?php

namespace App\Http\Controllers\Api;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\Api\ImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

# use App\Http\Controllers\Controller;

class ImagesController extends Controller
{
    /**
     * 图片上传功能
     * @param ImageRequest $request
     * @param ImageUploadHandler $uploader
     * @param Image $image
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $request, ImageUploadHandler $uploader, Image $image)
    {
        $user = $this->user();

        $size = $request->type == 'avatar' ? 362 : 1024;
        $result = $uploader->save($request->image, str_plural($request->image_type), $user->id, $size);

        $image->path = $result['path'];
        $image->image_type = $request->image_type;
        $image->user_id = $user->id;
        $image->save();

        return $this->created(new ImageResource($image));
    }
}

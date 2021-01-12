<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Services\Tag\SaveTag;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Http\Resources\TagsOptionsResource;

class TagController extends Controller
{
    public function list()
    {
        $tags = Tag::all();
        return TagResource::collection($tags);
    }

    public function save(TagRequest $request, Tag $tag = null)
    {
        $formData = $request->all();
        $saveTag = new SaveTag($formData, $tag);
        return response()->json($saveTag->handle());
    }

    public function tag(Tag $tag)
    {
        return new TagResource($tag);
    }

    public function options()
    {
        $tags = Tag::all();
        return TagsOptionsResource::collection($tags);
    }

}

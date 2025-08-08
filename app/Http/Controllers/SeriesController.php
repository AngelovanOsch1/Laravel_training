<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Traits\HandlesPhotos;
use App\Http\Requests\SeriesRequest;
use App\Http\Resources\ResponseResource;
use App\Http\Resources\SeriesResource;
use App\Http\Responses\SuccessResponse;
use App\Http\Resources\SeriesListResource;

class SeriesController extends Controller
{
    use HandlesPhotos;

    public function index()
    {
        $series = Series::with(['genres', 'studios', 'themes'])->paginate(15);
        return SeriesListResource::collection($series);
    }

    public function show(Series $series)
    {
        $series->load(['genres', 'studios', 'themes']);
        return new SeriesResource($series);
    }

    public function store(SeriesRequest $request)
    {
        $validated = $request->validated();

        $validated['cover_image'] = $this->uploadPhoto($request->file('cover_image'), 'series');

        // $validated['owner_id'] = $request->user()->id;
        // cant do that cus you cant logged in

        $validated['owner_id'] = 1;

        $series = Series::create($validated);

        return new SeriesListResource($series);
    }

    public function update(SeriesRequest $request, Series $series)
    {
        $validated = $request->validated();

        $this->deletePhoto($series->cover_image);
        $validated['cover_image'] = $this->uploadPhoto($request->file('cover_image'), 'series');

        $series->update($validated);
        return new SeriesResource($series->fresh(['genres', 'studios', 'themes']));
    }

    public function destroy(Series $series)
    {
        $this->deletePhoto($series->cover_image);
        $series->delete();

        return new ResponseResource(ResponseResource::DELETED_SERIES);
    }
}

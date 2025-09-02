<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesImageCoverRequest;
use App\Models\Series;
use App\Traits\HandlesPhotos;
use App\Http\Requests\SeriesRequest;
use App\Http\Resources\ResponseResource;
use App\Http\Resources\SeriesCoverImageResource;
use App\Http\Resources\SeriesResource;
use App\Http\Resources\SeriesListResource;

class SeriesController extends Controller
{
    use HandlesPhotos;

    public function index()
    {
        $series = Series::paginate(3);
        return SeriesListResource::collection($series);
    }

    public function show(Series $series)
    {
        $series->load(['genres', 'studios', 'themes', 'characterVoiceActorSeries.character', 'characterVoiceActorSeries.voiceActor']);
        return new SeriesResource($series);
    }

    public function store(SeriesRequest $request)
    {
        $validated = $request->validated();

        // $validated['owner_id'] = $request->user()->id;
        // cant do that cus you cant logged in

        $validated['owner_id'] = 1;

        $series = Series::create($validated);

        return new SeriesListResource($series);
    }

    public function update(SeriesRequest $request, Series $series)
    {
        $validated = $request->validated();

        $series->update($validated);
        $series->fresh();

        return new SeriesListResource($series);
    }

    public function destroy(Series $series)
    {
        $this->deletePhoto($series->cover_image);
        $series->delete();

        return new ResponseResource(ResponseResource::DELETED_SERIES);
    }

    public function updateCoverImage(SeriesImageCoverRequest $request, Series $series)
    {
        $request->validated();

        if ($series->cover_image) {
            $this->deletePhoto($series->cover_image);
        }

        $coverImagePath = $this->uploadPhoto($request->file('cover_image'), 'series');

        $series->update([
            'cover_image' => $coverImagePath,
        ]);

        return new SeriesCoverImageResource($series);
    }

    public function test()
    {
        return new ResponseResource(ResponseResource::CONNECTED);
    }
}

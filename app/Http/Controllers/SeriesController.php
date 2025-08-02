<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Traits\HandlesPhotos;
use App\Http\Requests\SeriesCreateRequest;
use App\Http\Requests\SeriesUpdateRequest;
use App\Http\Resources\SeriesResource;

class SeriesController extends Controller
{
    use HandlesPhotos;

    public function index()
    {
        $series = Series::with(['genres', 'studios', 'themes'])->paginate(15);
        return SeriesResource::collection($series);
    }

    public function show(Series $series)
    {
        $series->load(['genres', 'studios', 'themes']);
        return new SeriesResource($series);
    }

    public function store(SeriesCreateRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $this->uploadPhoto($request->file('cover_image'), 'series');
        }

        // $validated['owner_id'] = $request->user()->id;
        // cant do that cus you cant logged in

        $validated['owner_id'] = 1;

        $series = Series::create($validated);

        if (isset($validated['genres'])) {
            $series->genres()->attach($validated['genres']);
        }

        if (isset($validated['studios'])) {
            $series->studios()->attach($validated['studios']);
        }

        if (isset($validated['character_voice_actors'])) {
            foreach ($validated['character_voice_actors'] as $pair) {
                $series->characterVoiceActorSeries()->create([
                    'character_id' => $pair['character_id'],
                    'voice_actor_id' => $pair['voice_actor_id'],
                ]);
            }
        }

        $themesToInsert = [];
        foreach ($request->themes as $index => $theme) {
            $fileKey = "themes.$index.audio_url";
            if ($request->hasFile($fileKey)) {
                $audioPath = $this->uploadPhoto($request->file($fileKey), 'themes');
            }

            $themesToInsert[] = [
                'title' => $theme['title'],
                'artist' => $theme['artist'],
                'audio_url' => $audioPath,
                'type' => $theme['type'],
            ];
        }

        $series->themes()->createMany($themesToInsert);

        return new SeriesResource($series->load(['genres', 'studios', 'themes']));
    }

    public function update(SeriesUpdateRequest $request, Series $series)
    {
        $validated = $request->validated();

        if ($request->hasFile('cover_image')) {
            $this->deletePhoto($series->cover_image);
            $validated['cover_image'] = $this->uploadPhoto($request->file('cover_image'), 'series');
        }

        $series->update($validated);
        return new SeriesResource($series->fresh(['genres', 'studios', 'themes']));
    }

    public function destroy(Series $series)
    {
        $this->deletePhoto($series->cover_image);
        $series->delete();

        return response()->json(['message' => 'Series deleted successfully.']);
    }
}

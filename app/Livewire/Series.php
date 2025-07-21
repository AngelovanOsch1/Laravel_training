<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Reaction;
use App\Models\SeriesUser;
use App\Support\GlobalHelper;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use App\Models\Series as SeriesModel;

#[Layout('layouts.app')]
class Series extends Component
{
    public User $loggedInUser;
    public SeriesModel $series;
    public object $reactionsObject;

    public function mount(int $id)
    {
        $this->series = SeriesModel::with(['genres', 'studios'])->find($id);
        $this->loggedInUser = GlobalHelper::getLoggedInUser();
        $this->series->amount_of_votes = SeriesUser::where('series_id', $this->series->id)->count();
        $this->series->rank = SeriesModel::where('score', '>', $this->series->score)->count() + 1;
        $this->series->airing_status = $this->calculateAiringStatus($this->series);
        $this->series->premiered = $this->getSeasonFromDate(Carbon::parse($this->series->aired_start_date));
        $this->refreshReactions();
    }

    public function render()
    {
        return view('livewire.series');
    }

    public function calculateAiringStatus(SeriesModel $series)
    {
        $today = now();
        $start = Carbon::parse($series->aired_start_date);
        $end = Carbon::parse($series->aired_end_date);

        if ($today->lt($start)) return 'Not yet aired';
        if ($today->between($start, $end)) return 'Airing';
        return 'Finished Airing';
    }

    function getSeasonFromDate(Carbon $date): string
    {
        $year = $date->year;
        $month = $date->month;

        return match (true) {
            $month >= 1 && $month <= 3 => "Winter $year",
            $month >= 4 && $month <= 6 => "Spring $year",
            $month >= 7 && $month <= 9 => "Summer $year",
            $month >= 10 && $month <= 12 => "Fall $year",
        };
    }

    public function refreshReactions()
    {
        $reactions = $this->series->reactions;

        $hasAlreadyLiked = $reactions->where('user_id', $this->loggedInUser->id)
            ->where('type', 'like')
            ->isNotEmpty();

        $hasAlreadyDisliked = $reactions->where('user_id', $this->loggedInUser->id)
            ->where('type', 'dislike')
            ->isNotEmpty();

        $likeCount = $reactions->where('type', 'like')->count();
        $dislikeCount = $reactions->where('type', 'dislike')->count();

        $this->reactionsObject = (object) [
            'hasalreadyLiked' => $hasAlreadyLiked,
            'hasalreadyDisliked' => $hasAlreadyDisliked,
            'likeCount' => $likeCount,
            'dislikeCount' => $dislikeCount,
        ];
    }

    public function toggleReactionSeries(string $type)
    {
        $existingReaction = Reaction::where('user_id', $this->loggedInUser->id)
            ->where('reactionable_id', $this->series->id)
            ->where('reactionable_type', SeriesModel::class)
            ->first();

        if ($existingReaction) {
            if ($existingReaction->type === $type) {
                $existingReaction->delete();
            } else {
                $existingReaction->type = $type;
                $existingReaction->save();
            }
        } else {
            Reaction::create([
                'user_id' => $this->loggedInUser->id,
                'reactionable_id' => $this->series->id,
                'reactionable_type' => SeriesModel::class,
                'type' => $type,
            ]);
        }

        $this->refreshReactions();
    }
}

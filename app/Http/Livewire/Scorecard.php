<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Scorecard as ScorecardModel;

class Scorecard extends Component
{
    public $scorecards;

    public function mount($id)
    {
        $this->scorecards = ScorecardModel::with(['golfer', 'comments', 'category', 'images', 'videos', 'tags'])->find($id);
    }

    public function render()
    {
        return view('livewire.scorecard');
    }
}

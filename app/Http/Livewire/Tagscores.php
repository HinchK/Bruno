<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Scorecard;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Tagscores extends Component
{
    use WithPagination;

    public $title, $content, $category, $scorecard_id, $score;
    public $tagids = array();
    public $isOpen = 0;

    public $tid;

    public function mount($id)
    {
        // $this->resetInputFields();
        $this->tid = $id;
    }

    public function render()
    {
        return view('livewire.scorecards', [
            'scores' => Tag::findOrFail($this->tid)->scores()->paginate(),
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ]);
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'content' => 'required',
            'category' => 'required',
            'score' => 'required',
        ]);

        $scorecard = Scorecard::updateOrCreate(['id' => $this->scorecard_id], [
            'title' => $this->title,
            'content' => $this->content,
            'category_id' => intval($this->category),
            'score' => $this->score,
            'golfer_id' => Auth::user()->id,
        ]);

        if (count($this->tagids) > 0) {

            DB::table('scorecard_tag')->where('scorecard_id', $scorecard->id)->delete();

            foreach ($this->tagids as $tagid) {
                DB::table('scorecard_tag')->insert([
                    'scorecard_id' => $scorecard->id,
                    'tag_id' => intval($tagid)
                ]);
            }
        }

        session()->flash(
            'message',
            $this->scorecard_id ? 'Scorecard Updated Successfully.' : 'Scorecard Created Successfully.'
        );

        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        Scorecard::find($id)->delete();
        session()->flash('message', 'Scorecard Deleted Successfully.');
    }

    public function edit($id)
    {
        $scorecard = Scorecard::with('tags')->findOrFail($id);

        $this->scorecard_id = $id;
        $this->title = $scorecard->title;
        $this->content = $scorecard->content;
        $this->category = $scorecard->category_id;
        $this->score = $scorecard->score;
        $this->tagids = $scorecard->tags->pluck('id');

        $this->openModal();
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->title = '';
        $this->content = '';
        $this->category = null;
        $this->tagids = null;
        $this->score = '';
        $this->scorecard_id = '';
    }
}

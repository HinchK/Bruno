<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CourseScores extends Component
{
    use WithPagination;

    public $title;
    public $content;
    public $course_title;
    public $course_par;
    public $score_id;
    public $isOpen = 0;

    public $course_id;

    public function mount($id)
    {
        $this->course_id = $id;
    }

    public function render()
    {
        return view('livewire.course-scores', [
            'scores' => Scorecards::where('course_id', $this->course_id)->orderBy('id', 'desc')->paginate(),
            'categories' => Category::all(),
            'tags' => Tag::all(),
            'courses' => Course::all(),
        ]);
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'content' => 'required',
            'score' =>  'required',
            'category' => 'required',
        ]);

        $score = Scorecard::updateOrCreate(['id' => $this->score_id], [
            'title' => $this->title,
            'content' => $this->content,
            'category_id' => intval($this->category),
            'score' => $this->score,
            'golfer_id' => Auth::user()->id,
        ]);

        if (count($this->tagids) > 0) {
            DB::table('scorecard_tag')->where('score_id', $score->id)->delete();

            foreach ($this->tagids as $tagid) {
                DB::table('scorecard_tag')->insert([
                    'score_id' => $score->id,
                    'tag_id' => intval($tagid),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        session()->flash(
            'message',
            $this->score_id ? 'Scorecard Updated Successfully.' : 'Scorecard Created Successfully.'
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
        $score = Scorecard::with('tags')->findOrFail($id);

        $this->score_id = $id;
        $this->title = $score->title;
        $this->content = $score->content;
        $this->category = $score->category_id;
        $this->tagids = $score->tags->pluck('id');

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
        $this->score_id = '';
    }
}

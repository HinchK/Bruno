<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Image;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Scorecard;
use App\Models\Category;
use Livewire\WithPagination;

class Scorecards extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $title;
    public $content;
    public $category;
    public $course;
    public $scorecard_id;
    public $score;
    public $tagids = array();
    public $photos = [];
    public $isOpen = 0;

    public function render()
    {
        return view('livewire.scorecards', [
            'scores' => Scorecard::orderBy('id', 'desc')->paginate(),
            'categories' => Category::all(),
            'courses' => Course::all(),
            'tags' => Tag::all(),
        ]);
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'content' => 'required',
            'category' => 'required',
            'course' => 'required',
            'score' => 'required',
            'photos.*' => 'image|max:1024',
        ]);

        // Update or Insert Post
        $scorecard = Scorecard::updateOrCreate(['id' => $this->scorecard_id], [
            'title' => $this->title,
            'content' => $this->content,
            'category_id' => intval($this->category),
            'course_id' => intval($this->course),
            'score' => $this->score,
            'golfer_id' => Auth::user()->id,
        ]);

        // Image upload and store name in db
        if (count($this->photos) > 0) {
            Image::where('scorecard_id', $scorecard->id)->delete();
            $counter = 0;
            foreach ($this->photos as $photo) {
                $storedImage = $photo->store('public/photos');

                $featured = false;
                if ($counter == 0) {
                    $featured = true;
                }
                Image::create([
                    'url' => url('storage'. Str::substr($storedImage, 6)),
                    'title' => '-',
                    'scorecard_id' => $scorecard->id,
                    'featured' => $featured
                ]);
                $counter++;
            }
        }

        // Scorecard Tag mapping
        if (count($this->tagids) > 0) {
            DB::table('scorecard_tag')->where('scorecard_id', $scorecard->id)->delete();

            foreach ($this->tagids as $tagid) {
                DB::table('scorecard_tag')->insert([
                    'scorecard_id' => $scorecard->id,
                    'tag_id' => intval($tagid),
                    'created_at' => now(),
                    'updated_at' => now(),
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
        DB::table('scorecard_tag')->where('scorecard_id', $id)->delete();

        session()->flash('message', 'Scorecard Deleted Successfully.');
    }

    public function edit($id)
    {
        $scorecard = Scorecard::with('tags')->findOrFail($id);

        $this->scorecard_id = $id;
        $this->title = $scorecard->title;
        $this->score = $scorecard->score;
        $this->content = $scorecard->content;
        $this->category = $scorecard->category_id;
        $this->tagids = $scorecard->tags->pluck('id');
        $this->course = $scorecard->course_id;

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
        $this->title = null;
        $this->content = null;
        $this->category = null;
        $this->course = null;
        $this->tagids = null;
        $this->photos = null;
        $this->score = null;
        $this->scorecard_id = null;
    }
}

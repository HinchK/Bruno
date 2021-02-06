<?php

namespace App\Http\Livewire;

use App\Models\Course;
use Livewire\Component;

class Courses extends Component
{
    public $courses;
    public $title;
    public $course_id;
    public $par;
    public $isOpen = 0;


    public function render()
    {
        $this->courses = Course::all();
        return view('livewire.courses');
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            'par' => 'required',
        ]);

        Course::updateOrCreate(['id' => $this->course_id],
            [
                'title' => $this->title,
                'par' => $this->par
            ]
        );

        session()->flash(
            'message',
            $this->course_id ? 'Golf Course Updated Successfully.' : 'Golf Course Created Successfully.'
        );

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $this->course_id = $id;
        $this->title = $course->title;
        $this->par = $course->par;

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
        $this->course_id = '';
        $this->par = '';
    }

    public function delete($id)
    {
        Course::find($id)->delete();
        session()->flash('message', 'Golf Course Deleted Successfully.');

    }
}

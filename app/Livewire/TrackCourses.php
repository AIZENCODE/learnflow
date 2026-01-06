<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Track;
use Livewire\Component;

class TrackCourses extends Component
{
    public $trackId;
    public $search = '';
    public $selectedCourseId = null;

    public function mount($track)
    {
        $this->trackId = is_object($track) ? $track->id : $track;
    }

    public function getTrackProperty()
    {
        return Track::findOrFail($this->trackId);
    }

    public function addCourse($courseId)
    {
        $course = Course::find($courseId);
        $track = $this->track;
        if ($course && $course->track_id != $track->id) {
            $course->update(['track_id' => $track->id]);
            $this->search = ''; // Limpiar búsqueda
            $this->dispatch('course-added');
        }
    }

    public function removeCourse($courseId)
    {
        try {
            $course = Course::findOrFail($courseId);
            $track = $this->track;
            if ($course->track_id == $track->id) {
                $course->update(['track_id' => null]);
                $this->dispatch('course-removed');
            }
        } catch (\Exception $e) {
            $this->dispatch('course-error', message: 'Error al eliminar el curso: ' . $e->getMessage());
        }
    }

    public function getAvailableCoursesProperty()
    {
        $track = $this->track;
        return Course::where(function($query) use ($track) {
                $query->whereNull('track_id')
                      ->orWhere('track_id', '!=', $track->id);
            })
            ->where('title', 'like', '%' . $this->search . '%')
            ->orderBy('title')
            ->limit(10)
            ->get();
    }

    public function render()
    {
        $track = $this->track;
        $trackCourses = $track->courses()->orderBy('order_in_track')->get();
        
        return view('livewire.track-courses', [
            'trackCourses' => $trackCourses,
        ]);
    }
}


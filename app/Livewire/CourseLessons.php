<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class CourseLessons extends Component
{
    public $courseId;
    public $showLessonModal = false;
    public $showItemModal = false;
    public $showQuestionsModal = false;
    public $editingLesson = null;
    public $editingItem = null;
    public $selectedLessonId = null;
    
    // Formulario de lección
    public $lessonTitle = '';
    public $lessonSlug = '';
    public $lessonDescription = '';
    public $lessonOrder = 0;
    public $lessonXpPoints = 0;
    public $lessonIsPublished = true;
    
    // Formulario de item
    public $itemTitle = '';
    public $itemDescription = '';
    public $itemOrder = 0;
    public $itemContentType = 'video';
    public $itemCompletionType = 'automatic';
    public $itemContent = '';
    public $itemVideoUrl = '';
    public $itemVideoDuration = null;
    public $itemExternalUrl = '';
    public $itemFilePath = '';
    public $itemIsPreview = false;
    public $itemIsPublished = true;
    public $itemRequiresCompletion = true;
    public $itemXpPoints = 0;

    public function mount($course)
    {
        $this->courseId = is_object($course) ? $course->id : $course;
    }

    public function getCourseProperty()
    {
        return Course::findOrFail($this->courseId);
    }

    public function openLessonModal($lessonId = null)
    {
        $this->editingLesson = $lessonId;
        if ($lessonId) {
            $lesson = Lesson::findOrFail($lessonId);
            $this->lessonTitle = $lesson->title;
            $this->lessonSlug = $lesson->slug;
            $this->lessonDescription = $lesson->description ?? '';
            $this->lessonOrder = $lesson->order;
            $this->lessonXpPoints = $lesson->xp_points;
            $this->lessonIsPublished = $lesson->is_published;
        } else {
            $this->resetLessonForm();
        }
        $this->showLessonModal = true;
    }

    public function closeLessonModal()
    {
        $this->showLessonModal = false;
        $this->editingLesson = null;
        $this->resetLessonForm();
    }

    public function saveLesson()
    {
        $validated = $this->validate([
            'lessonTitle' => 'required|string|max:255',
            'lessonSlug' => 'nullable|string|max:255',
            'lessonDescription' => 'nullable|string',
            'lessonOrder' => 'required|integer|min:0',
            'lessonXpPoints' => 'required|numeric|min:0',
            'lessonIsPublished' => 'boolean',
        ]);

        $data = [
            'title' => $validated['lessonTitle'],
            'slug' => empty($validated['lessonSlug']) ? Str::slug($validated['lessonTitle']) : $validated['lessonSlug'],
            'description' => $validated['lessonDescription'],
            'order' => $validated['lessonOrder'],
            'xp_points' => $validated['lessonXpPoints'],
            'is_published' => $this->lessonIsPublished,
            'course_id' => $this->courseId,
            'updated_by' => Auth::id(),
        ];

        if ($this->editingLesson) {
            $lesson = Lesson::findOrFail($this->editingLesson);
            $lesson->update($data);
        } else {
            $data['created_by'] = Auth::id();
            Lesson::create($data);
        }

        $this->closeLessonModal();
        $this->dispatch('lesson-saved');
    }

    public function deleteLesson($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        $lesson->delete();
        $this->dispatch('lesson-deleted');
    }

    public function openItemModal($lessonId, $itemId = null)
    {
        $this->selectedLessonId = $lessonId;
        $this->editingItem = $itemId;
        if ($itemId) {
            $item = LessonItem::findOrFail($itemId);
            $this->itemTitle = $item->title;
            $this->itemDescription = $item->description ?? '';
            $this->itemOrder = $item->order;
            $this->itemContentType = $item->content_type;
            $this->itemCompletionType = $item->completion_type;
            $this->itemContent = $item->content ?? '';
            $this->itemVideoUrl = $item->video_url ?? '';
            $this->itemVideoDuration = $item->video_duration;
            $this->itemExternalUrl = $item->external_url ?? '';
            $this->itemFilePath = $item->file_path ?? '';
            $this->itemIsPreview = $item->is_preview;
            $this->itemIsPublished = $item->is_published;
            $this->itemRequiresCompletion = $item->requires_completion;
            $this->itemXpPoints = $item->xp_points;
        } else {
            $this->resetItemForm();
        }
        $this->showItemModal = true;
    }

    public function closeItemModal()
    {
        $this->showItemModal = false;
        $this->editingItem = null;
        $this->selectedLessonId = null;
        $this->resetItemForm();
    }

    public function saveItem()
    {
        $validated = $this->validate([
            'itemTitle' => 'required|string|max:255',
            'itemDescription' => 'nullable|string',
            'itemOrder' => 'required|integer|min:0',
            'itemContentType' => 'required|in:video,article,quiz,assignment,download,external_link,live_session',
            'itemCompletionType' => 'required|in:automatic,quiz,manual,text_answer,file_upload,external',
            'itemContent' => 'nullable|string',
            'itemVideoUrl' => 'nullable|url',
            'itemVideoDuration' => 'nullable|integer|min:0',
            'itemExternalUrl' => 'nullable|url',
            'itemFilePath' => 'nullable|string|max:255',
            'itemIsPreview' => 'boolean',
            'itemIsPublished' => 'boolean',
            'itemRequiresCompletion' => 'boolean',
            'itemXpPoints' => 'required|numeric|min:0',
        ]);

        $data = [
            'title' => $validated['itemTitle'],
            'description' => $validated['itemDescription'],
            'order' => $validated['itemOrder'],
            'content_type' => $validated['itemContentType'],
            'completion_type' => $validated['itemCompletionType'],
            'content' => $validated['itemContent'],
            'video_url' => $validated['itemVideoUrl'],
            'video_duration' => $validated['itemVideoDuration'],
            'external_url' => $validated['itemExternalUrl'],
            'file_path' => $validated['itemFilePath'],
            'is_preview' => $this->itemIsPreview,
            'is_published' => $this->itemIsPublished,
            'requires_completion' => $this->itemRequiresCompletion,
            'xp_points' => $validated['itemXpPoints'],
            'lesson_id' => $this->selectedLessonId,
            'updated_by' => Auth::id(),
        ];

        if ($this->editingItem) {
            $item = LessonItem::findOrFail($this->editingItem);
            $item->update($data);
        } else {
            $data['created_by'] = Auth::id();
            LessonItem::create($data);
        }

        $this->closeItemModal();
        $this->dispatch('item-saved');
    }

    public function deleteItem($itemId)
    {
        $item = LessonItem::findOrFail($itemId);
        $item->delete();
        $this->dispatch('item-deleted');
    }

    public function openQuestionsModal($itemId)
    {
        $this->selectedLessonId = $itemId;
        $this->showQuestionsModal = true;
    }

    public function closeQuestionsModal()
    {
        $this->showQuestionsModal = false;
        $this->selectedLessonId = null;
    }

    public function resetLessonForm()
    {
        $this->lessonTitle = '';
        $this->lessonSlug = '';
        $this->lessonDescription = '';
        $this->lessonOrder = 0;
        $this->lessonXpPoints = 0;
        $this->lessonIsPublished = true;
    }

    public function resetItemForm()
    {
        $this->itemTitle = '';
        $this->itemDescription = '';
        $this->itemOrder = 0;
        $this->itemContentType = 'video';
        $this->itemCompletionType = 'automatic';
        $this->itemContent = '';
        $this->itemVideoUrl = '';
        $this->itemVideoDuration = null;
        $this->itemExternalUrl = '';
        $this->itemFilePath = '';
        $this->itemIsPreview = false;
        $this->itemIsPublished = true;
        $this->itemRequiresCompletion = true;
        $this->itemXpPoints = 0;
    }

    public function render()
    {
        $course = $this->course;
        $lessons = $course->lessons()->with('lessonItems')->orderBy('order')->get();
        
        return view('livewire.course-lessons', [
            'lessons' => $lessons,
        ]);
    }
}


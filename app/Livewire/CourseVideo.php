<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Video;

class CourseVideo extends Component
{
    public $courseId;
    public $videoId;
    public $comments = [];
    public $newComment = '';
    public $likesCount = 0;
    public $hasLiked = false;
    
    // Los datos del video
    public $video = null;

    protected $listeners = ['updateVideo' => 'updateVideo', 'updateLike' => 'updateLike', 'updateCount' => 'updateCount', 'updateComments' => 'updateComments'];


    public function mount($courseId, $videoId)
    {
        $this->courseId = $courseId;
        $this->videoId = $videoId;
        
    }
    
    public function render()
    {
        return view('livewire.course-video');
    }
    
    public function updateVideo($videoData)
    {
        $this->video = $videoData;
    }

    function getEmbedUrl($url)
    {
        // Validar YouTube
        if (preg_match('/youtu\.be\/|youtube\.com\/watch\?v=|youtube\.com\/embed\//', $url)) {
            preg_match('/(?:v=|\/)([a-zA-Z0-9_-]{11})/', $url, $matches);
            return isset($matches[1]) ? "https://www.youtube.com/embed/{$matches[1]}" : null;
        }


        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return $url; 
        }

        // URL no válida
        return null;
    }

    public function updateLike($like)
    {
        if(!$this->hasLiked){
            $this->likesCount += $like;
            $this->hasLiked = true;
        }
        
    }

    public function updateCount($count , $liked){
        $this->likesCount = $count;
        $this->hasLiked = $liked;
    }

    public function updateComments($comments)
    {
        $this->comments = $comments;
    }
}

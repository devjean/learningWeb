<div class="course-video-container">
    @if ($video)
        <h1 class="text-3xl font-bold">{{ $video['title'] }}</h1>
        <div class="video-player">
            <iframe 
                width="560" 
                height="315" 
                src="{{ $this->getEmbedUrl($video['video_url']) }}" 
                frameborder="0" 
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen
            ></iframe>
        </div>
        
        <!-- Botón de Like -->
        <div class="mt-4">
            <button 
                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600"
                id="likeButton"
                @if ($hasLiked) disabled @endif
                onclick="likeVideo('{{ $videoId }}')"
            >
                @if ($hasLiked)
                    Ya has dado Like
                @else
                    Dar Like
                @endif
            </button>
            <p class="mt-2">Likes: {{ $likesCount }}</p>
        </div>

        <!-- Comentarios -->
        <div class="comments-section mt-6">
            <h2 class="text-2xl font-semibold">Comentarios</h2>

            <div class="comment-form mt-4">
                <textarea 
                    wire:model="newComment" 
                    id="newComment"
                    class="w-full p-2 border rounded-md" 
                    placeholder="Escribe un comentario..."
                ></textarea>
                <button 
                    id="commentButton"
                    class="mt-2 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600"
                    onclick="addComment('{{ $videoId }}', document.getElementById('newComment').value)"
                >
                    Enviar Comentario
                </button>
            </div>

            @foreach ($comments as $comment)
                <div class="comment mt-4 p-4 border rounded-md">
                    <p><strong>{{ $comment['user']['name'] }}:</strong></p>
                    <p>{{ $comment['content'] }}</p>
                </div>
            @endforeach
        </div>
    @else
        <p>Loading video...</p>
    @endif
</div>

<script>
    const apiToken = localStorage.getItem('api_token');
    let hasLiked = false;
    let likesCount = 0;
    
    async function getVideo() {
        if (apiToken) {
            try {
                const response = await fetch('/api/courses/{{ $courseId }}/videos/{{ $videoId }}', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${apiToken}`,
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                });

                if (response.ok) {
                    const videoResponse = await response.json();
                    @this.video = videoResponse;
                    Livewire.dispatch('updateVideo', {videoData: videoResponse});
                } else {
                    console.error('Error fetching video data:', response.status);
                }

                // Obtener los comentarios
                const commentsResponse = await fetch(`/api/videos/{{ $videoId }}/comments`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${apiToken}`,
                    },
                });

                if (commentsResponse.ok) {
                    const commentsData = await commentsResponse.json();
                    @this.comments = commentsData;
                } else {
                    console.error('Error fetching comments:', commentsResponse.status);
                }

                // Obtener likes
                const likesResponse = await fetch(`/api/videos/{{ $videoId }}/likes`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${apiToken}`,
                    },
                });

                if (likesResponse.ok) {
                    const likesData = await likesResponse.json();
                    console.log(likesData)
                    @this.likesCount = likesData.likes_count;
                    @this.hasLiked = likesData.has_liked;
                    Livewire.dispatch('updateCount', {count: likesData.likes_count, liked: likesData.has_liked});
                } else {
                    console.error('Error fetching likes:', likesResponse.status);
                }
            } catch (error) {
                console.error('Error occurred during the API calls:', error);
            }
        } else {
            console.error('No token available');
        }
    }

    async function addComment(videoId, newComment) {
        if (!newComment) return;

        try {
            const response = await fetch(`/api/videos/${videoId}/comments`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${apiToken}`,
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    comment: newComment,
                }),
            });

            if (response.ok) {
                const comments = await response.json();
                Livewire.dispatch('updateComments', {comments: comments});
                document.getElementById('newComment').value = ''; 
            } else {
                console.error('Error al agregar el comentario');
            }
        } catch (error) {
            console.error('Error al enviar el comentario:', error);
        }
    }

    async function likeVideo(videoId) {
        
        if (hasLiked) {
            console.log('Ya has dado like a este video.');
            return;
        }

        try {
            const response = await fetch(`/api/videos/${videoId}/likes`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${apiToken}`,
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            });

            if (response.ok) {
                const data = await response.json();
                console.log('Like agregado:', data);
                likesCount++;
                hasLiked = true;
                Livewire.dispatch('updateLike', {like: 1});
            } else {
                console.error('Error al dar like al video');
            }
        } catch (error) {
            console.error('Error al dar like al video:', error);
        }
    }
    
    getVideo();
</script>
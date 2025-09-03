<div>
@if (!$is_deleted)

<div class="mb-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h5 class="card-text border-0 text-dark">{{ $post->title }}</h5>
                @can ('delete-post', $post)
                    <button
                        wire:click="deletePost"
                        wire:confirm="Are you sure you want to delete this post?"
                        class="btn btn-sm border-0 bg-transparent text-danger rounded-pill"
                        title="Delete"
                        style="padding: 0;">
                        <i class="bi bi-trash"></i>
                    </button>
                @endcan
            </div>

            @php
                $LINE_COUNT_THRESHOLD = 5;
                $CHAR_COUNT_THRESHOLD = 500;

                $postContent = $post->content;

                $length_good = function($string) use($CHAR_COUNT_THRESHOLD) {
                    return strlen($string) <= $CHAR_COUNT_THRESHOLD;
                };

                $lines_good = function($string) use($LINE_COUNT_THRESHOLD) {
                    return substr_count($string, "\n") <= $LINE_COUNT_THRESHOLD;
                };

                $is_good = function($string) use ($length_good, $lines_good) {
                    return $length_good($string) && $lines_good($string);
                };

                $try_fix = !$is_good($postContent);

                while (!$is_good($postContent)) {
                    if (!$length_good($postContent)) {
                        $postContent = mb_substr($postContent, 0, $CHAR_COUNT_THRESHOLD);
                    }

                    if (!$lines_good($postContent)) {
                        $postContent = preg_replace('/\n.*$/s', '', $postContent);
                    }
                }

                if ($try_fix) {
                    $postContent = trim($postContent) . "...";
                }

            @endphp

            <p class="card-text" style="white-space: pre-line;">{{ !$showcase ? $postContent : $post->content }}</p>

            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <small class="text-muted me-2">{{ $post->created_at->diffForHumans() }}</small>
                    @if ($post->parent_id == null)
                        <small class="text-muted me-2"><i class="bi bi-chat"></i> {{ $post->children->count() }}</small>
                    @endif
                    <small class="text-muted">Created by 
                        <a href="{{ route('members.show', $post->author->id) }}" class="fst-italic text-muted text-decoration-underline">{{ $post->author->name }}
                        </a>
                    </small>
                </div>
                <div>
                    @if (!$showcase && ($try_fix || $post->children->count() > 0))
                        <a href="{{ route('groups.posts.show', [$group, $post]) }}" class="btn text-white px-3 bg-dark btn-sm rounded-pill text-decoration-none">View</a>
                    @endif
                    @if ($commentsEnabled)
                        <button wire:click="startCommenting" class="btn text-white px-3 bg-primary btn-sm rounded-pill">Comment</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- commenting box --}}
    @if ($isCommenting)
        <div class="mt-2 p-3">
            <div class="position-relative p-3 pb-2" style="border-radius: 20px; background-color: rgba(0,0,0,0.05)">
                <textarea wire:model="comment" maxlength="5000" class="form-control bg-transparent mb-2 border-0" rows="3" placeholder="Write a comment..." style="resize:none;"></textarea>
                <div class="d-flex justify-content-end gap-2">
                    <button wire:click="stopCommenting" class="btn btn-sm bg-danger text-white px-3 rounded-pill" title="Cancel">
                        <i class="bi bi-x text-white"></i> Cancel
                    </button>
                    <button wire:click="postComment" class="btn btn-sm bg-primary text-white px-3 rounded-pill" title="Submit">
                        <i class="bi bi-send"></i> Comment
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- recursively import children posts (but we are only limitting commenting on root level posts aka: no commenting on comments) --}}
    @if ($post->parent_id == null && $showcase)
        <div class="mt-2 ms-3 ps-3 border-start">
            @foreach($post->children->sortByDesc('created_at') as $childPost)
                <livewire:post-card :post="$childPost" :group="$group" :key="$childPost->id" />
            @endforeach
        </div>
    @endif
</div>

@endif
</div>

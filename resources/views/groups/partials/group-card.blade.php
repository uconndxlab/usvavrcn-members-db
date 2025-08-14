
@php
    $cardColor = match (true) {
        str_starts_with($group->name, 'Team:') => '#2769f4', // blue
        str_starts_with($group->name, 'Focus:') => '#f4bd27', // yellow
        str_starts_with($group->name, 'Committee:') => '#cc41ef', // pink
        default => '#57be57', // green
    };
@endphp
<a href="{{ route('groups.show', $group) }}" class="text-decoration-none text-dark group-card-hover-anim">
    <div class="card h-100" style="border-left: 6px solid {{ $cardColor }};">
        <div class="card-body">
            <div class="mb-3">
                <h5 class="card-title mb-1">{{ $group->name }}</h5>
                <small class="text-muted">
                    {{ $group->members ? $group->members->count() : 0 }} members
                </small>
                @if($group->description)
                    <p class="card-text text-muted small mt-2">{{ Str::limit($group->description, 100) }}</p>
                @endif
            </div>

            @if($group->tags && $group->tags->isNotEmpty())
            <div class="mb-3">
                @foreach($group->tags as $tag)
                    <span class="badge bg-secondary me-1">{{ $tag->name }}</span>
                @endforeach
            </div>
            @endif

            @if($group->posts && $group->posts->isNotEmpty())
                <div class="text-end">
                    <small class="text-muted">
                        <i class="bi bi-chat"></i> {{ $group->posts->count() }} posts
                    </small>
                </div>
            @endif
        </div>
    </div>
</a>

<style>

.group-card-hover-anim .card {
    transition: all 0.25s ease;
}

.group-card-hover-anim:hover .card {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    border-left-width: 10px !important;
}

.group-card-hover-anim:hover {
    text-decoration: none !important;
}
</style>
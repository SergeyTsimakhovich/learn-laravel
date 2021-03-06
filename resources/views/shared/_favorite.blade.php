<a href="" 
    title="Click to mark as favorite question (Click again to undo)" 
    class="favorite mt-2 {{ Auth::guest() ? 'off' : $model->is_favorited }}"
    onclick="event.preventDefault(); getElementById('favorite-question-{{ $model->id }}').submit();">
    <i class="fas fa-star fa-2x"></i>
    <span class="favorites-count">{{ $model->favorites_count }}</span>
</a>
<form action="{{ route('questions.favorite', $model->id) }}" id="favorite-question-{{ $model->id }}" method="POST" style="display:none;">
    @csrf
    @if ($model->is_favorited)
        @method('DELETE')
    @endif
</form>
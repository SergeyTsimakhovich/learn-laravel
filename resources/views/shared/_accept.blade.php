@can('accept', $model) 
    <a href="" title="Mark this answer as best answer" 
        class="{{ $model->status }} mt-2"
        onclick="event.preventDefault(); getElementById('accept-answer-{{ $model->id }}').submit();">
        <i class="fas fa-check fa-2x"></i>
    </a>                          
    <form action="{{ route('answers.accept', $model->id) }}" id="accept-answer-{{ $model->id }}" method="POST" style="display:none;">
        @csrf
    </form>
@else
    @if ($model->is_best)
        <a href="" title="Author this question accept this answer as best answer" class="{{ $model->status }} mt-2">
            <i class="fas fa-check fa-2x"></i>
        </a>
    @endif 
@endcan
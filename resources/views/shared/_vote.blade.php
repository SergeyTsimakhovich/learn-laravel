@if ($model instanceOf App\Question)
    @php
        $name = 'question';
        $firstURISegment = 'questions';
    @endphp
@elseif ($model instanceOf App\Answer)
    @php
        $name = 'answer';
        $firstURISegment = 'answers';
    @endphp
@endif

@php
    $formId = $name . "-" . $model->id;
    $formAction = $firstURISegment . ".vote";
@endphp

<div class="d-flex flex-column vote-controls">

    {{-- Votes Block Start --}}
    <a href="" title="This {{ $name }} is useful" 
        class="vote-up {{ Auth::guest() ? 'off' : '' }}"
        onclick="event.preventDefault(); getElementById('up-vote-{{ $formId }}').submit();">
        <i class="fas fa-caret-up fa-3x"></i>
    </a>
    <form action="{{ route($formAction, $model->id) }}" id="up-vote-{{ $formId }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="vote" value="1">
    </form>

    <span class="votes-count">
        {{ $model->votes_count }}
    </span>

    <a href="" title="This {{ $name }} is not useful" 
        class="vote-down {{ Auth::guest() ? 'off' : '' }}"
        onclick="event.preventDefault(); getElementById('down-vote-{{ $formId }}').submit();">
        <i class="fas fa-caret-down fa-3x"></i>
    </a>
    <form action="{{ route($formAction, $model->id) }}" id="down-vote-{{ $formId }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="vote" value="-1">
    </form>
    {{-- Votes Block End --}}

    @if ($model instanceOf App\Question)
        {{-- @include('shared._favorite', ['model' => $model]) --}}
        <favorite :question="{{ $model }}"></favorite>
    @elseif ($model instanceOf App\Answer)
        {{-- @include('shared._accept', ['model' => $model]) --}}
        <accept :answer="{{ $model }}"></accept>
    @endif

</div>
@if($rating)
    @for($i = 1; $i <= 5; $i++)
        @if($i <= $rating)
            ◆
        @else
            ◇
        @endif
    @endfor
@else
    No rating yet...
@endif

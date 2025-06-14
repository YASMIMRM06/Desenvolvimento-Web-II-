@props(['rating', 'size' => 'sm'])

@php
    $sizeClasses = [
        'sm' => 'text-sm',
        'md' => 'text-md',
        'lg' => 'text-lg',
        'xl' => 'text-xl'
    ];
@endphp

<div class="d-inline-block {{ $sizeClasses[$size] ?? $sizeClasses['sm'] }}">
    @for($i = 1; $i <= 5; $i++)
        @if($i <= floor($rating))
            <i class="fas fa-star text-warning"></i>
        @elseif($i - 0.5 <= $rating)
            <i class="fas fa-star-half-alt text-warning"></i>
        @else
            <i class="far fa-star text-warning"></i>
        @endif
    @endfor
</div>
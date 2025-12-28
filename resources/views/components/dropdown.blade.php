@props(['align' => 'end', 'width' => '48', 'contentClasses' => 'dropdown-menu'])

<div class="dropdown" {{ $attributes }}>
    <div data-bs-toggle="dropdown" aria-expanded="false">
        {{ $trigger }}
    </div>

    <ul class="dropdown-menu dropdown-menu-{{ $align }}">
        {{ $content }}
    </ul>
</div>
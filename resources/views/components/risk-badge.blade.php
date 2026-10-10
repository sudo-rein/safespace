@props(['level', 'urgent' => false, 'size' => 'xs'])

@php
    $sizeClass = $size === 'sm' ? 'px-3 py-1 text-sm' : 'px-2 py-1 text-xs';
    $styles = [
        'low' => ['bg-yellow-100 text-yellow-800 border border-yellow-300', 'Low', 'Low Risk'],
        'medium' => ['bg-orange-100 text-orange-800 border border-orange-300', 'Medium', 'Medium Risk'],
        'high' => ['bg-red-100 text-red-800 border border-red-300', 'High', 'High Risk'],
    ];
    $levelKey = is_string($level) || is_int($level) ? (string) $level : 'low';
    [$class, $short, $long] = $styles[$levelKey] ?? $styles['low'];
@endphp

@if ($urgent)
    <span class="{{ $sizeClass }} rounded-full bg-gray-900 text-white font-semibold">URGENT</span>
@endif

<span class="{{ $sizeClass }} rounded-full {{ $class }}">{{ $size === 'sm' ? $long : $short }}</span>
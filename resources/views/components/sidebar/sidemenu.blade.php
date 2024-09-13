@props(['collapsed'=>true, 'data-bs-toggle'=>'','target'=>'','aria-expanded'=>''
,'aria-controls'=>'','item'=>'','icon'=>''])

@php
    $defaults=[
        'data-bs-toggle'=>'collapse',
        'data-bs-target'=>'#'.$target,
        'aria-expanded'=>false,
        'aria-controls'=>$target
    ];

    $classes= $collapsed ? 'nav-link collapsed': 'nav-link';
    $attr= $collapsed ? $defaults : [];
    $arrow= $collapsed ? 'fas fa-angle-down' : '';
@endphp

<a  {{$attributes->merge(['class'=>$classes,'data-bs-toggle'=>$attr['data-bs-toggle']??null,
'data-bs-target'=>$attr['data-bs-target']??null,
'aria-expanded'=>$attr['aria-expanded']??null,'aria-controls'=>$attr['aria-controls']??null])}}>
    <div class="sb-nav-link-icon"><i class="{{$icon}}"></i></div>
    {{$item}}
    <div class="sb-sidenav-collapse-arrow"><i class="{{$arrow}}"></i></div>
    {{$slot}}
</a>





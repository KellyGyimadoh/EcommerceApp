@props(['name','label'=>''])

@php
    $defaults=[
        'id'=>$name,
        'type'=>'text',
        'class'=>'form-control',
        'name'=>$name
    ];
@endphp


<x-forms.field :name="$name" :label="$label">
    <input {{$attributes->merge($defaults)}} value="{{old($name)}}"/>
</x-forms.field>


@props(['name'=>''])
<select class="form-select" {{$attributes->merge(['name'=>$name])}}>
    {{$slot}}
</select>
<x-forms.error :error="$errors->first($name)"/>

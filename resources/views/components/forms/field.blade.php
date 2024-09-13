@props(['name','label',])



        <div {{$attributes->merge(['class'=>'form-floating mb-3'])}}>
            {{$slot}}
            <x-forms.label :name="$name" :label="$label" />
            <x-forms.error :error="$errors->first($name)"/>
        </div>



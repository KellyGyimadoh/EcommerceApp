<x-layout pagetitle=" Add New Categories" pageurl="/categories-add">
    <div class="container-fluid px-4">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-1">Add New Category</h3>
                    </div>
                    <div class="card-body">
                        <x-forms.form method="POST" action="/categories-add">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <x-forms.input name="name" label="Category Name" placeholder="Category Name" :value="old('name')" />
                                </div>
                                <div class="col-md-6">
                                    <x-forms.input name="description" label="Description" :value="old('description')" placeholder="sweet food" />

                                </div>
                            </div>


                            <div class="mt-4 mb-0">
                                <div class="d-grid"><x-forms.button class="btn btn-primary btn-block">
                                        Add New Category</x-forms.button>
                                </div>
                            </div>
                        </x-forms.form>
                    </div>



                </div>
            </div>
        </div>
    </div>

</x-layout>

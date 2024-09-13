<x-layout pagetitle="Categories" pageurl="/categories">

    <div class="card shadow-lg border-0 rounded-lg px-4 ">
        @if ($categories->isEmpty())
            <p class="text-danger text-center fs-4">No categories available</p>
            <div class="d-flex justify-content-center mb-3">
                <a class="btn btn-warning" href="/categories-add">Add New Category</a>
            </div>
        @else
            <div class="d-flex justify-content-end">
                <div>
                    <form action="/searchcategories" method="GET">

                        <input type="search" name="q" placeholder="Search for Category" />
                        <select name="categorytype">
                            <option value="all">All</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-success">search</button>
                    </form>
                </div>
            </div>
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Categories
            </div>
            <div class="card-body justify-content-center">
                <table class="table table-striped table-hover ">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>

                            <th scope="col">Action</th>

                        </tr>
                    </thead>
                    <tfoot class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td scope="row">{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description }}</td>
                                <td>
                                    <div>
                                        <a role="button" data-bs-toggle="modal" data-bs-target="#edit"
                                            class="btn btn-success" data-id="{{ $category->id }}">Edit</a>
                                        <a role="button" data-bs-toggle="modal" data-bs-target="#delete"
                                            class="btn btn-danger" data-id="{{ $category->id }}">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    {{ $categories->links() }}
                </table>
            </div>
            <x-modal target="edit" action="Edit Category" modaltitle="Edit Category" formtarget="editform">
                <x-forms.form id="editform" method="POST">
                    @method('PATCH')
                    <x-forms.input name="name" label="Name Of Category" placeholder="name" />
                    <x-forms.input name="description" label="Description" placeholder="description" />

                </x-forms.form>
            </x-modal>
            <x-modal target="delete" action="Delete Category" modaltitle="Delete Category?" formtarget="deleteform">
                <p>Are you sure you want to delete Category</p>
                <x-forms.form method="POST" id="deleteform">
                    @method('DELETE')

                </x-forms.form>
            </x-modal>
        @endif


    </div>
</x-layout>

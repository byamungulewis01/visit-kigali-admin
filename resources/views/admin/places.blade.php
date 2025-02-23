@extends('layouts.app')
@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="card" id="List">
                <div class="card-header border-bottom-dashed">

                    <div class="row g-4 align-items-center">
                        <div class="col-sm">
                            <div>
                                <h5 class="card-title mb-0">Places List</h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">

                                <button type="button" class="btn btn-primary add-btn"
                                    data-action="{{ route('places.store') }}" data-bs-toggle="modal" id="create-btn"
                                    data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Add
                                    Place</button>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="datatable" class="table align-middle" style="width: 100%">
                        <thead class="table-light text-muted">
                            <tr>
                                <th scope="col" style="width: 20px;">#</th>
                                <th class="sort" data-sort="place">Place</th>
                                <th class="sort" data-sort="price">Price</th>
                                <th class="sort" data-sort="rating">Rating</th>
                                <th class="sort" data-sort="published">Published</th>
                                <th class="sort" data-sort="status">Status</th>
                                <th class="sort" data-sort="action">Action</th>
                            </tr>
                        </thead>

                        <tbody class="gridjs-tbody">
                            @foreach ($places as $place)
                                <tr class="gridjs-tr">
                                    <td data-column-id="#" class="gridjs-td">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td data-column-id="product" class="gridjs-td"><span>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar-sm rounded p-1">
                                                        <img src="{{ asset("storage/{$place->image}") }}" alt=""
                                                            class="img-fluid d-block">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-14 mb-1"><span
                                                            class="text-body">{{ $place->name }}</span></h5>
                                                    <p class="text-muted mb-0">Category : <span
                                                            class="fw-medium">{{ $place->category }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </span></td>
                                    <td data-column-id="price" class="gridjs-td">
                                        <span>{{ number_format($place->price) }}</span>
                                    </td>
                                    <td data-column-id="rating" class="gridjs-td">
                                        <span>
                                            @for ($i = 0; $i < $place->rating; $i++)
                                                ⭐️
                                            @endfor
                                        </span>
                                    </td>
                                    <td data-column-id="published" class="gridjs-td">
                                        <span>{{ $place->created_at->format('d M, Y') }}</span>
                                    </td>

                                    <td class="gridjs-td"><span
                                            class="badge {{ $place->status == 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">{{ ucfirst($place->status) }}</span>
                                    </td>

                                    <td class="gridjs-td">
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                data-bs-placement="top" title="Remove">
                                                <a class="text-info d-inline-block"
                                                    href="{{ route('places.show', $place->id) }}">
                                                    <i class="ri-eye-fill fs-16"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                <a href="#showModal" data-bs-toggle="modal" data-id="{{ $place->id }}"
                                                    data-name="{{ $place->name }}" data-price="{{ $place->price }}"
                                                    data-category="{{ $place->category }}"
                                                    data-rating="{{ $place->rating }}" data-status="{{ $place->status }}"
                                                    data-short_description="{{ $place->short_description }}"
                                                    data-long_description="{{ $place->long_description }}"
                                                    data-action="{{ route('places.update', ['place' => $place->id]) }}"
                                                    class="text-primary d-inline-block edit-btn">
                                                    <i class="ri-pencil-fill fs-16"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                data-bs-placement="top" title="Remove">
                                                <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal"
                                                    data-id="{{ $place->id }}" href="#deleteRecordModal">
                                                    <i class="ri-delete-bin-5-fill fs-16"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>


                <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            <form class="tablelist-form" method="POST" autocomplete="off"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="modal-body">

                                    <input type="hidden" value="{{ old('id') }}" name="id" id="id" />

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" name="name" value="{{ old('name') }}" id="name"
                                            class="form-control" placeholder="Enter name" />
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label for="category" class="form-label">Category</label>
                                            <select class="form-select" name="category" id="category">
                                                <option value="" selected disabled>Select</option>
                                                <option {{ old('category') == 'Lakes' ? 'selected' : '' }} value="Lakes">
                                                    Lakes</option>
                                                <option {{ old('category') == 'Rivers' ? 'selected' : '' }}
                                                    value="Rivers">
                                                    Rivers</option>
                                                <option {{ old('category') == 'Mountains' ? 'selected' : '' }}
                                                    value="Mountains"> Mountains</option>
                                                <option {{ old('category') == 'Forests' ? 'selected' : '' }}
                                                    value="Forests"> Forests</option>
                                                <option {{ old('category') == 'Caves' ? 'selected' : '' }} value="Caves">
                                                    Caves</option>
                                                <option {{ old('category') == 'Museums' ? 'selected' : '' }}
                                                    value="Museums"> Museums</option>
                                                <option {{ old('category') == 'Religious Sites' ? 'selected' : '' }}
                                                    value="Religious Sites"> Religious Sites</option>
                                                <option {{ old('category') == 'Zoos & Safari Parks' ? 'selected' : '' }}
                                                    value="Zoos & Safari Parks"> Zoos & Safari Parks </option>
                                                <option {{ old('category') == 'Skyscrapers & Towers' ? 'selected' : '' }}
                                                    value="Skyscrapers & Towers"> Skyscrapers & Towers </option>
                                            </select>
                                            @error('category')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label for="price" class="form-label">Price (RWF)</label>
                                            <input type="number" min="0" name="price"
                                                value="{{ old('price') }}" id="price" class="form-control"
                                                placeholder="Enter price" />
                                            @error('price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="short_description" class="form-label">Short Description</label>
                                        <textarea name="short_description" id="short_description" rows="3" class="form-control"
                                            placeholder="Enter description">{{ old('short_description') }}</textarea>
                                        @error('short_description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-4">
                                            <label for="image_file" class="form-label">Image</label>
                                            <input type="file" accept=".jpeg,.png,.jpg" name="image_file"
                                                id="image_file" class="form-control" />
                                            @error('image_file')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-4">
                                            <label for="rating" class="form-label">Rating</label>
                                            <select class="form-select" name="rating" id="rating">
                                                <option value="" selected disabled>Select</option>
                                                <option {{ old('rating') == 1 ? 'selected' : '' }} value="1">
                                                    ⭐️ </option>
                                                <option {{ old('rating') == 2 ? 'selected' : '' }} value="2">
                                                    ⭐️ ⭐️ </option>
                                                <option {{ old('rating') == 3 ? 'selected' : '' }} value="3">
                                                    ⭐️ ⭐️ ⭐️ </option>
                                                <option {{ old('rating') == 4 ? 'selected' : '' }} value="4">
                                                    ⭐️ ⭐️ ⭐️ ⭐️
                                                </option>
                                                <option {{ old('rating') == 5 ? 'selected' : '' }} value="5">
                                                    ⭐️ ⭐️ ⭐️ ⭐️ ⭐️ </option>
                                            </select>
                                            @error('rating')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-4">
                                            <label for="status-field" class="form-label">Status</label>
                                            <select class="form-select" name="status" id="status-field">
                                                <option value="" selected disabled>Select</option>
                                                <option {{ old('status') == 'active' ? 'selected' : '' }} value="active">
                                                    Active</option>
                                                <option {{ old('status') == 'inactive' ? 'selected' : '' }}
                                                    value="inactive">
                                                    Inactive</option>
                                            </select>
                                            @error('status')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    {{-- description --}}
                                    <div class="mb-0">
                                        <label for="long_description" class="form-label">More Details</label>
                                        <textarea name="long_description" id="long_description" rows="5" class="form-control"
                                            placeholder="Enter description">{{ old('long_description') }}</textarea>
                                        @error('long_description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" id="add-btn">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal"
                                    aria-label="Close" id="btn-close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="delete-form" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <div class="mt-2 text-center">
                                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                            colors="primary:#f7b84b,secondary:#f06548"
                                            style="width:100px;height:100px"></lord-icon>
                                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                            <h4>Are you sure ?</h4>
                                            <p class="text-muted mx-4 mb-0">Are you sure you want to remove this record ?
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                        <button type="button" class="btn w-sm btn-light"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn w-sm btn-danger" id="delete-record">Yes, Delete
                                            It!</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end modal -->
            </div>
        </div>

    </div>
    <!--end col-->
    </div>
    <!--end row-->
@endsection
@section('css')
    @include('layouts.datatable.css-without-bottons')
    {{-- @include('layouts.datatable.css-with-bottons') --}}
@endsection
@section('js')
    <!--datatable js-->
    @include('layouts.datatable.js-without-bottons')
    {{-- @include('layouts.datatable.js-with-bottons') --}}
    <script>
        $('#datatable').DataTable();
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '#create-btn', function() {
                document.getElementById("exampleModalLabel").innerHTML = "Add New Place";
                var form_action = $(this).data('action');
                $('.tablelist-form').attr('action', form_action);
            });

            // update updateitem modl with clicked button data
            $(document).on('click', '.edit-btn', function() {

                document.getElementById("exampleModalLabel").innerHTML = "Edit Place";;
                document.getElementById("add-btn").innerHTML = "Save Changes";
                $('.tablelist-form').attr('action', $(this).data('action')).append(
                    '<input type="hidden" name="_method" value="PUT">');
                $('#id').val($(this).data('id'));
                $('#name').val($(this).data('name'));
                $('#price').val($(this).data('price'));
                $('#category').val($(this).data('category'));
                $('#rating').val($(this).data('rating'));
                $('#short_description').val($(this).data('short_description'));
                $('#long_description').val($(this).data('long_description'));
                $('#status-field').val($(this).data('status'));

            });

            $(document).on('click', '.remove-item-btn', function() {
                var route = "{{ route('places.destroy', ['place' => ':id']) }}";
                route = route.replace(':id', $(this).data('id'));
                $('.delete-form').attr('action', route);
            });
        });
    </script>

    @if ($errors->any())
        @if (old('id'))
            <script>
                document.getElementById("add-btn").innerHTML = "Save Changes";
                document.getElementById("exampleModalLabel").innerHTML = "Edit Place";


                var myModal = new bootstrap.Modal(document.getElementById('showModal'), {
                    keyboard: false
                })
                myModal.show()

                var id = "{{ old('id') }}";
                var route = "{{ route('places.update', ['place' => ':id']) }}";
                route = route.replace(':id', id);

                $('.tablelist-form').attr('action', route).append('<input type="hidden" name="_method" value="PUT">');
            </script>
        @else
            <script>
                document.getElementById("exampleModalLabel").innerHTML = "Add New Place";

                var myModal = new bootstrap.Modal(document.getElementById('showModal'), {
                    keyboard: false
                })
                myModal.show()
            </script>
        @endif
    @endif
@endsection

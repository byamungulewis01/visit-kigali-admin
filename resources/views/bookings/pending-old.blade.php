@extends('layouts.app')
@section('body')
    <div class="row">
        <div class="col-md-12">
            <div class="card" id="List">
                <div class="card-header border-bottom-dashed">

                    <div class="row g-4 align-items-center">
                        <div class="col-sm">
                            <div>
                                <h5 class="card-title mb-0">Pending List</h5>
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
                                <th class="sort" data-sort="name">Name</th>
                                <th class="sort" data-sort="email">Email</th>
                                <th class="sort" data-sort="booking_date">Booking Date</th>
                                <th class="sort" data-sort="comment">Comment</th>
                                <th class="sort" data-sort="action">Action</th>
                            </tr>
                        </thead>

                        <tbody class="gridjs-tbody">
                            @foreach ($bookings as $booking)
                                <tr class="gridjs-tr">
                                    <td data-column-id="#" class="gridjs-td">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td data-column-id="product" class="gridjs-td">
                                        <h5 class="fs-14 mb-1">{{ $booking->place->name }}</h5>
                                    </td>
                                    <td data-column-id="name" class="gridjs-td">
                                        {{ $booking->name }}
                                    </td>
                                    <td data-column-id="email" class="gridjs-td">
                                        {{ $booking->email }}
                                    </td>
                                    <td data-column-id="booking_date" class="gridjs-td">
                                        {{ $booking->booking_date->format('d M, Y H:i:s') }}
                                    </td>
                                    <td data-column-id="comment" class="gridjs-td">
                                        <small>{{ $booking->comment }}</small>
                                    </td>


                                    <td class="gridjs-td">
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                data-bs-placement="top" title="Approve">
                                                <a class="text-primary d-inline-block approve-request"
                                                    data-bs-toggle="modal" data-id="{{ $booking->id }}"
                                                    href="#approveRequest">
                                                    <i class="ri-checkbox-line fs-16"></i>
                                                </a>
                                            </li>
                                            <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                data-bs-placement="top" title="Reject">
                                                <a class="text-danger d-inline-block reject-request" data-bs-toggle="modal"
                                                    data-id="{{ $booking->id }}" href="#rejectRequest">
                                                    <i class="ri-close-circle-line fs-16"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>

                <!-- Modal -->
                <div class="modal fade zoomIn" id="approveRequest" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal"
                                    aria-label="Close" id="btn-close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="approve-form" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="mt-2 text-center">
                                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop"
                                            colors="primary:#f7b84b,secondary:#405189" style="width:130px;height:130px">
                                        </lord-icon>
                                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                            <h4>Are you sure ?</h4>
                                            <p class="text-muted mx-4 mb-0">Are you sure you want to approve this?
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                        <button type="button" class="btn w-sm btn-light"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn w-sm btn-primary" id="delete-record">Yes,
                                            Approve
                                            It!</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="rejectRequest" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title">Reject request</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            <form class="reject-form" method="POST" autocomplete="off">
                                @csrf
                                @method('PUT')

                                <div class="modal-body">
                                    {{-- description --}}
                                    <div class="mb-0">
                                        <label for="reject_message" class="form-label">Reason to reject a request</label>
                                        <textarea name="reject_message" id="reject_message" rows="5" class="form-control"
                                            placeholder="Enter description">{{ old('reject_message') }}</textarea>
                                        @error('reject_message')
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

            </div>
        </div>
    </div>
    <!--end col-->
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

            $(document).on('click', '.approve-request', function() {
                var route = "{{ route('booking_approve', ['booking' => ':id']) }}";
                route = route.replace(':id', $(this).data('id'));
                $('.approve-form').attr('action', route);
            });

            $(document).on('click', '.reject-request', function() {
                var route = "{{ route('booking_reject', ['booking' => ':id']) }}";
                route = route.replace(':id', $(this).data('id'));
                $('.reject-form').attr('action', route);
            });
        });
    </script>
@endsection

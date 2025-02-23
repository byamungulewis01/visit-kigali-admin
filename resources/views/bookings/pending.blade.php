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
                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap gap-2">
                            <div class="input-group">
                                <input type="text" id="start_date" class="form-control form-control-sm flatpickr"
                                    placeholder="Start Date">
                                <input type="text" id="end_date" class="form-control form-control-sm flatpickr"
                                    placeholder="End Date">
                                <button type="button" id="filter" class="btn btn-primary btn-sm">
                                    <i class="ri-filter-2-line"></i> Filter
                                </button>
                                <button type="button" id="reset" class="btn btn-light btn-sm">
                                    <i class="ri-refresh-line"></i> Reset
                                </button>
                            </div>
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
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $booking->place->name }}</td>
                            <td>{{ $booking->name }}</td>
                            <td>{{ $booking->email }}</td>
                            <td>{{ $booking->booking_date->format('d M, Y H:i:s') }}</td>
                            <td><small>{{ $booking->comment }}</small></td>
                            <td>
                                <ul class="list-inline hstack gap-2 mb-0">
                                    <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                        data-bs-placement="top" title="Approve">
                                        <a class="text-primary d-inline-block approve-request" data-bs-toggle="modal"
                                            data-id="{{ $booking->id }}" href="#approveRequest">
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

            <!-- Your existing modals remain unchanged -->

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
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
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
@endsection

@section('css')
@include('layouts.datatable.css-without-bottons')
@include('layouts.datatable.css-with-bottons')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('js')
@include('layouts.datatable.js-without-bottons')
@include('layouts.datatable.js-with-bottons')

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    $(document).ready(function () {
        // Initialize flatpickr for date inputs
        flatpickr(".flatpickr", {
            dateFormat: "Y-m-d"
        });

        // Initialize DataTable with export buttons
        var table = $('#datatable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            order: [[4, 'desc']],
        });

        // Date range filtering
        $('#filter').click(function () {
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();

            if (startDate && endDate) {
                // Custom filtering function
                $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                    var bookingDate = new Date(data[4]); // Index 4 is the booking date column
                    var start = new Date(startDate);
                    var end = new Date(endDate);

                    return (bookingDate >= start && bookingDate <= end);
                });

                table.draw();

                // Remove the custom filtering function
                $.fn.dataTable.ext.search.pop();
            } else {
                alert('Please select both start and end dates');
            }
        });

        // Reset filters
        $('#reset').click(function () {
            $('#start_date').val('');
            $('#end_date').val('');
            table.search('').columns().search('').draw();
        });

        // Initialize approve/reject request handlers
        $(document).on('click', '.approve-request', function () {
            var route = "{{ route('booking_approve', ['booking' => ':id']) }}";
            route = route.replace(':id', $(this).data('id'));
            $('.approve-form').attr('action', route);
        });

        $(document).on('click', '.reject-request', function () {
            var route = "{{ route('booking_reject', ['booking' => ':id']) }}";
            route = route.replace(':id', $(this).data('id'));
            $('.reject-form').attr('action', route);
        });
    });
</script>
@endsection

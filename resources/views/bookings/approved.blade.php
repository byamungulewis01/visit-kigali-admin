@extends('layouts.app')
@section('body')
<div class="row">
    <div class="col-md-12">
        <div class="card" id="List">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">Approved List</h5>
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
                            <th class="sort" data-sort="fname">First Name</th>
                            <th class="sort" data-sort="lname">Last Name</th>
                            <th class="sort" data-sort="email">Email</th>
                            <th class="sort" data-sort="booking_date">Booking Date</th>
                            <th class="sort" data-sort="approved_date">Approved Date</th>
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
                                <td data-column-id="fname" class="gridjs-td">
                                    {{ $booking->tourist->fname }}
                                </td>
                                <td data-column-id="lname" class="gridjs-td">
                                    {{ $booking->tourist->lname }}
                                </td>
                                <td data-column-id="email" class="gridjs-td">
                                    {{ $booking->tourist->email }}
                                </td>
                                <td data-column-id="booking_date" class="gridjs-td">
                                    {{ $booking->booking_date->format('d M, Y H:i:s') }}
                                </td>
                                <td data-column-id="approved_or_rejected_date" class="gridjs-td">
                                    {{ $booking->approved_or_rejected_date->format('d M, Y H:i:s') }}
                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>
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

    });
</script>
@endsection



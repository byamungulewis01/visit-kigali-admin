@extends('layouts.app')
@section('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row gx-lg-5">
                        <div class="col-xl-4 col-md-8 mx-auto">
                            <img src="{{ asset("storage/{$place->image}") }}" alt="" class="img-fluid d-block" />

                        </div>
                        <!-- end col -->

                        <div class="col-xl-8">
                            <div class="mt-xl-0 mt-5">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h4>{{ $place->name }}</h4>
                                        <div class="hstack gap-3 flex-wrap">
                                            <p class="text-muted mb-0">Category : <span
                                                    class="fw-bold">{{ $place->category }}</span>
                                            </p>
                                            <div class="vr"></div>
                                            <div class="text-muted">Published : <span
                                                    class="text-body fw-medium">{{ $place->created_at->format('d M, Y') }}</span>
                                            </div>
                                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                                <div class="text-muted fs-16">
                                                    @for ($i = 0; $i < $place->rating; $i++)
                                                        ⭐️
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="mt-4 text-muted">
                                    <h5 class="fs-14">Description :</h5>
                                    <p>{{ $place->long_description }}</p>
                                </div>


                                @if ($place->reviews->count() > 0)
                                    <div class="mt-5">
                                        <div class="row gx-0">
                                            <div class="col-lg-12">
                                                <div class="d-flex flex-wrap align-items-start gap-3">
                                                    <h5 class="fs-14">Reviews: </h5>
                                                </div>

                                                <div class="me-lg-n3 pe-lg-4" data-simplebar style="max-height: 225px;">
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach ($reviews as $item)
                                                            <li class="py-2 {{ $item->is_top_rated ? '' : 'opacity-50' }}">
                                                                <div class="border border-dashed rounded p-3">
                                                                    <div class="d-flex align-items-start mb-3">
                                                                        <div class="hstack gap-3">
                                                                            <div class="badge rounded-pill bg-success mb-0">
                                                                                <i class="mdi mdi-star"></i>
                                                                                {{ $item->rating }}
                                                                            </div>
                                                                            <div class="vr"></div>
                                                                            <div class="flex-grow-1">
                                                                                <p class="text-muted mb-0">
                                                                                    {{ $item->content }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex align-items-end mb-2">
                                                                        <div class="flex-grow-1">
                                                                            <h5 class="fs-14 mb-0">{{ $item->name }}</h5>
                                                                        </div>
                                                                        <div class="flex-shrink-0">
                                                                            <p class="text-muted fs-13 mb-0">
                                                                                {{ $item->created_at->format('d M, Y') }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Added email information -->
                                                                    <div class="d-flex align-items-center mb-2">
                                                                        <div class="flex-grow-1">
                                                                            <p class="text-muted fs-13 mb-0">
                                                                                <i
                                                                                    class="mdi mdi-email-outline me-1"></i>{{ $item->email }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Added deactivate button -->
                                                                    @if ($item->is_top_rated)
                                                                        <div class="text-end">
                                                                            <form
                                                                                action="{{ route('places.review', $item->id) }}"
                                                                                method="post">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                <button type="button"
                                                                                    class="btn btn-sm btn-outline-danger"
                                                                                    onclick="if(confirm('Are you sure you want to deactivate this review?')) this.form.submit();">
                                                                                    <i
                                                                                        class="mdi mdi-close-circle me-1"></i>Deactivate
                                                                                    Review
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <!-- end Ratings & Reviews -->
                                    </div>
                                    <!-- end card body -->
                                @endif
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
@endsection
@section('css')
@endsection
@section('js')
@endsection

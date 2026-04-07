{{-- Session Pricing List --}}
<div class="card-light">
    <!-- header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-semibold mb-0"> Session Pricing </h4>
            <small class="text-muted"> Manage your session charges </small>
        </div>
        <button class="btn btn-danger btn-sm px-3" onclick="openAddPriceModal()">
            <i class="bi bi-plus-circle me-1"></i>
            Add Price
        </button>
    </div>
    <div class="row g-3">
        @forelse($mentor->sessionPrices as $price)
            <div class="col-md-6">
                <div class="price-box">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="price-duration">{{ $price->duration_minutes }} min </div>
                            <div class="price-value">
                                ₹ {{ $price->price }}
                            </div>
                            @if ($price->discount_price)
                                <div class="price-discount">
                                    ₹ {{ $price->discount_price }}
                                </div>
                            @endif
                            <div class="price-meta mt-1">
                                <span class="badge bg-light text-dark">
                                    {{ ucfirst($price->session_type) }}
                                </span>
                                <span class="badge bg-light text-dark">
                                    {{ ucfirst($price->meeting_platform) }}
                                </span>
                            </div>
                        </div>
                        <div class="price-actions">
                            <button class="icon-btn"
                                onclick="editPrice(
                                '{{ $price->id }}',
                                '{{ $price->duration_minutes }}',
                                '{{ $price->price }}',
                                '{{ $price->discount_price }}',
                                '{{ $price->session_type }}',
                                '{{ $price->meeting_platform }}',
                                '{{ $price->is_free }}')">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <a href="{{ route('mentorprice.delete', $price->id) }}" class="icon-btn text-danger"
                                onclick="return confirm('Delete this price?')">

                                <i class="bi bi-trash"></i>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-box text-center">
                    <i class="bi bi-currency-rupee display-6 text-muted"></i>
                    <p class="text-muted mt-2 mb-1">
                        No session price added
                    </p>
                    <small class="text-muted">
                        Click "Add Price" to create pricing
                    </small>
                </div>
            </div>
        @endforelse
    </div>
</div>

<style>
    .price-box {

        border: 1px solid #eee;
        border-radius: 12px;
        padding: 16px;
        background: #fff;
        transition: .2s;
    }

    .price-box:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, .06);
    }

    .price-duration {
        font-size: 13px;
        color: #888;
    }

    .price-value {
        font-size: 22px;
        font-weight: 600;
        color: #E62434;
    }

    .price-discount {
        font-size: 13px;
        color: #999;
        text-decoration: line-through;
    }

    .price-meta .badge {
        font-size: 11px;
        padding: 5px 8px;
    }

    .price-actions {
        display: flex;
        gap: 6px;
    }

    .empty-box {
        padding: 40px 10px;
        border: 1px dashed #ddd;
        border-radius: 12px;
        background: #fafafa;
    }
</style>

{{-- Session Pricing Model --}}
<div class="modal fade" id="priceModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <form action="{{ route('mentorprice.store') }}" method="POST" id="priceForm">
                @csrf
                <input type="hidden" name="price_id" id="price_id">
                <!-- header -->
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="fw-semibold mb-1"> Session Price </h5>
                        <small class="text-muted">
                            Set duration and pricing for session
                        </small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <!-- body -->
                <div class="modal-body pt-3">
                    <div class="row g-3">
                        <!-- duration -->
                        <div class="col-6">

                            <label class="form-label small text-muted">
                                Duration
                            </label>

                            @php
                                $durations = [15, 20, 30, 45, 60, 90];
                            @endphp

                            <select name="duration_minutes" id="duration_minutes" class="form-select">
                                @foreach ($durations as $d)
                                    <option value="{{ $d }}">{{ $d }} minutes </option>
                                @endforeach
                            </select>

                        </div>
                        <!-- session type -->
                        <div class="col-6">
                            <label class="form-label small text-muted">Session Type</label>
                            <select name="session_type" id="session_type" class="form-select">
                                <option value="video">Video </option>
                            </select>
                        </div>
                        <!-- price -->
                        <div class="col-6">

                            <label class="form-label small text-muted">
                                Price (₹)
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    ₹
                                </span>

                                <input type="number" name="price" id="price" class="form-control"
                                    placeholder="Enter price">

                            </div>

                        </div>



                        <!-- discount -->
                        <div class="col-6">

                            <label class="form-label small text-muted">
                                Discount Price
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    ₹
                                </span>

                                <input type="number" name="discount_price" id="discount_price" class="form-control"
                                    placeholder="Optional">

                            </div>

                        </div>



                        <!-- platform -->
                        <div class="col-12">

                            <label class="form-label small text-muted">
                                Meeting Platform
                            </label>

                            <select name="meeting_platform" id="meeting_platform" class="form-select">

                                <option value="zoom">
                                    Zoom
                                </option>

                                <option value="google_meet">
                                    Google Meet
                                </option>

                            </select>

                        </div>



                        <!-- free -->
                        <div class="col-12">

                            <div class="form-check form-switch mt-1">

                                <input class="form-check-input" type="checkbox" name="is_free" id="is_free"
                                    value="1">

                                <label class="form-check-label fw-semibold">

                                    Free Session

                                </label>

                            </div>

                            <small class="text-muted">

                                When enabled, price will be ₹0

                            </small>

                        </div>


                    </div>

                </div>



                <!-- footer -->
                <div class="modal-footer border-0 pt-0">

                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">

                        Cancel

                    </button>

                    <button class="btn btn-danger px-4">

                        Save Price

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<style>
    .modal-content {
        border-radius: 14px;
    }

    .form-select,
    .form-control {
        height: 44px;
        border-radius: 8px;
        font-size: 14px;
    }

    .input-group-text {
        background: #f8f9fa;
        border-radius: 8px 0 0 8px;
    }

    .btn-danger {
        background: #E62434;
        border: none;
    }

    .btn-danger:hover {
        background: #c71f2e;
    }
</style>


<script>
    document.addEventListener("DOMContentLoaded", function() {

        const freeCheckbox = document.getElementById("is_free");
        const priceInput = document.getElementById("price");
        const discountInput = document.getElementById("discount_price");


        function toggleFree() {

            if (freeCheckbox.checked) {

                priceInput.value = 0;
                discountInput.value = 0;

                priceInput.readOnly = true;
                discountInput.readOnly = true;

            } else {

                priceInput.readOnly = false;
                discountInput.readOnly = false;

                priceInput.value = '';
                discountInput.value = '';

            }

        }


        freeCheckbox.addEventListener("change", toggleFree);

    });
</script>

<script>
    function openAddPriceModal() {

        document.getElementById("priceForm").action =
            "{{ route('mentorprice.store') }}";

        document.getElementById("price_id").value = "";

        document.getElementById("priceForm").reset();

        new bootstrap.Modal(
            document.getElementById('priceModal')
        ).show();

    }


    function editPrice(
        id,
        duration,
        price,
        discount,
        type,
        platform,
        free
    ) {

        document.getElementById("priceForm").action =
            "{{ url('/mentor/price/update') }}/" + id;

        document.getElementById("price_id").value = id;

        document.getElementById("duration_minutes").value = duration;

        document.getElementById("price").value = price;

        document.getElementById("discount_price").value = discount;

        document.getElementById("session_type").value = type;

        document.getElementById("meeting_platform").value = platform;

        document.getElementById("is_free").checked = free == 1;

        new bootstrap.Modal(
            document.getElementById('priceModal')
        ).show();

    }
</script>

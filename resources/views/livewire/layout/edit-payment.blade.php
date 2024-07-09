<div class="editPayment form-control">
    <div class="title form-control fw-bold">
        Thông tin thanh toán
    </div>
    <div class="mt-3 payment">
        <label class="form-label fw-bold">Phương thức thanh toán</label>
        <div class='w-100'>
            <img class="img-thumbnail {{ $payment == 'vnpay' ? 'active' : null }}"
                src="{{ asset('assets\img\images.png') }}" alt="vnpay" wire:click='paymentChange("vnpay")' />

            <img class="img-thumbnail {{ $payment == 'direct' ? 'active' : null }}"
                src="{{ asset('assets\img\thanh-toan-truc-tiep.webp') }}" alt="Thanh toán trực tiếp"
                wire:click='paymentChange("direct")' />
        </div>
    </div>
    <div class="mt-3">
        <label class="form-label fw-bold" for="note">Ghi chú</label>
        <textarea class="form-control w-100" id="note" wire:model.live='note'></textarea>
    </div> 
    <hr>
    <div class="mt-1">
        <b>Tổng tiền:</b>
        <span>{{ $carts->totalItems() }} (VND)</span>
    </div>
    <div class="mt-1">
        <b>Phí ship:</b>
        <span>1%</span>
    </div>
    <div class="mt-1">
        <b>Tổng tiền:</b>
        <span>{{ $carts->totalItems() - $carts->totalItems() * 0.01 }} (VND)</span>
    </div>
    <hr>
    <button type="button" class="btn w-100 btn-payment" wire:click='order'>
        Thanh toán!
    </button>

    <style>
        .editPayment {
            z-index: 1;
            position: sticky;
            top: 75px;
            width: 100%;
            border: 1px solid var(--coffee-black);
            box-shadow: 0 3px 3px var(--coffee-black);

            .title {
                background: var(--coffee-black);
                color: var(--milk);
            }

            .payment {
                div {
                    display: flex;
                    justify-content: space-between;

                    img {
                        width: 48%;
                        object-fit: cover;
                        cursor: pointer;
                        transition: 0.25s;

                        &:hover {
                            box-shadow: 0 3px 3px var(--coffee-black);
                            transition: 0.25s;
                        }

                        &.active {
                            background: var(--coffee-black);
                            border: 1px solid var(--coffee-black);
                        }
                    }
                }
            }

            .btn-payment {
                background: var(--coffee-black);
                color: var(--milk);
                font-weight: bold;
                transition: 0.25s;

                &:hover{
                    box-shadow: 0 3px 3px var(--coffee-black);
                    background: var(--coffee-milk);
                    color: var(--coffee-black);
                    transition: 0.25s;
                }
            }

            .mt-1{
                display: flex;
                justify-content: space-between;

                span{
                    font-weight: bold;
                    color: red;
                }
            }
        }
    </style>
</div>

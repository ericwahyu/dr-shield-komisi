@php
    use Carbon\Carbon;
@endphp
<div>
    {{-- The Master doesn't talk, he acts. --}}
    @include('livewire.invoice.ceramic-invoice.ceramic-invoice-detail.ceramic-invoice-detail-modal-v2')
    <div wire:loading.block wire:target="saveData">
        {{-- @include('layouts.admin.loading-screen') --}}
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="text-align: center">Data Faktur Keramik</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="form-label">Tanggal</div>
                            <input type="text" class="form-control @error('date') is-invalid @enderror" wire:model.live="date" placeholder="" disabled>
                            @error('date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <div class="form-label">Nomor Faktur</div>
                            <input type="text" class="form-control @error('invoice_number') is-invalid @enderror" wire:model="invoice_number" placeholder="" disabled>
                            @error('invoice_number')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-3">
                            <div class="form-label">Nama Penjual Utama</div>
                            <input type="text" class="form-control @error('sales_code') is-invalid @enderror" wire:model.live="sales_code" placeholder="" disabled>
                            @error('sales_code')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-3">
                            <div class="form-label">Masa Jatuh Tempo</div>
                            <input type="text" class="form-control @error('due_date') is-invalid @enderror" wire:model="due_date" min="0" placeholder="" disabled>
                            @error('due_date')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-3">
                            <div class="form-label">Nama Pelanggan</div>
                            <input type="text" class="form-control @error('customer') is-invalid @enderror" wire:model="customer" placeholder="" disabled>
                            @error('customer')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-3">
                            <div class="form-label">Id Pelanggan</div>
                            <input type="text" class="form-control @error('id_customer') is-invalid @enderror" wire:model="id_customer" placeholder="" disabled>
                            @error('id_customer')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <div class="form-label">Nominal DPP</div>
                            <input type="text" class="form-control @error('income_tax') is-invalid @enderror" wire:model.live="income_tax" min="0" placeholder="" disabled>
                            @error('income_tax')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <div class="form-label">Nilai PPN</div>
                            <input type="text" class="form-control @error('value_tax') is-invalid @enderror" wire:model="value_tax" min="0" placeholder="" disabled>
                            @error('value_tax')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-4">
                            <div class="form-label">Total</div>
                            <input type="text" class="form-control @error('amount') is-invalid @enderror" wire:model="amount" min="0" placeholder="" disabled>
                            @error('amount')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        @foreach ($due_date_ceramic_rules as $key => $due_date_ceramic_rule)
                            @if ($key == 0)
                                @continue
                            @endif
                            <div class="col-4">
                                <div class="form-label">{{ $due_date_ceramic_rule?->due_date }} Hari</div>
                                <input type="text" class="form-control" value="{{ Carbon::parse($get_invoice?->date)?->addDays($due_date_ceramic_rule?->due_date)?->format('d M Y') }}" disabled>
                                @error('amount')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="text-align: center">Rincian Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-label">Total </div>
                            <input type="text" class="form-control @error('amount') is-invalid @enderror" wire:model.live="amount" placeholder="" disabled>
                            @error('amount')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <div class="form-label">Nominal Terbayar</div>
                            <input type="text" class="form-control @error('payment_amount') is-invalid @enderror" value="{{ $payment_amount }}" placeholder="" disabled>
                            @error('count_amount')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <div class="form-label">Sisa Pembayaran</div>
                            <input type="text" class="form-control @error('remaining_amount') is-invalid @enderror" wire:model.live="remaining_amount" placeholder="" disabled>
                            @error('remaining_amount')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="text-align: center">Detail Pembayaran Faktur</h5>
                    <button type="submit" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-v2">Tambah </button>
                </div>
                <div class="table-responsive scrollbar-x">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 10px;">No</th>
                                <th class="text-center">Kategori</th>
                                <th class="text-center">Nominal</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Persentage</th>
                                <th class="text-center" style="width: 10px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($invoice_details as $result)
                                <tr>
                                    <td class = "text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">
                                        @if ($result?->type  == 'dr-shield')
                                            <b>Dr Shield</b>
                                        @elseif ($result?->type  == 'dr-sonne')
                                            <b>Dr Sonne</b>
                                        @elseif ($result?->type  == null)
                                            <b>Keramik</b>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class = "text-center">{{ $result?->amount ? number_format($result?->amount, 0, ',', '.') : '-' }}</td>
                                    <td class = "text-center">{{ $result?->date ? $result?->date?->format('d M Y') : '-' }}</td>
                                    <td class = "text-center">{{ $result?->percentage }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-danger btn-sm" wire:click="deleteConfirm('{{ $result?->id }}')" x-data="{ tooltip: 'Hapus' }" x-tooltip="tooltip"><i class="fa-solid fa-trash-alt fa-fw"></i></button>
                                        <button class="btn btn-warning btn-sm" wire:click="edit('{{ $result?->id }}')" x-data="{ tooltip: 'Edit' }" x-tooltip="tooltip"><i class="fa-solid fa-pencil-alt fa-fw"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center fw-bold">Belum Ada Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            Livewire.on("openModal", () => {
                jQuery('#modal-v2').modal('show');
            });
            Livewire.on("closeModal", () => {
                jQuery('#modal-v2').modal('hide');
            });

        });
    </script>
@endpush


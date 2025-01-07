@section('title', 'Detail Faktur Atap')
@php
    use Carbon\Carbon;
@endphp
<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    @include('livewire.invoice.roof-invoice.roof-invoice-detail-modal')
    <div wire:loading.block wire:target="saveData">
        {{-- @include('layouts.admin.loading-screen') --}}
    </div>
    <div class="d-flex align-items-center">
        <a href="{{ route('roof.invoice') }}" class="btn btn-icon" style="margin-right: 15px"><i class="fa-solid fa-arrow-left"></i></a>
        <div>
            <h3 class="mb-0 fw-semibold">Detail Faktur Atap</h3>
        </div>
    </div>
    <hr class="my-3">
    <div class="nav-align-top mb-6">
        <ul class="nav nav-pills mb-4 gap-3" role="tablist">
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link waves-effect waves-light" role="tab" data-bs-toggle="tab" data-bs-target="#version-1" aria-controls="version-1" aria-selected="true">Versi 1</button>
            </li>
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link active waves-effect waves-light" role="tab" data-bs-toggle="tab" data-bs-target="#version-2" aria-controls="version-2" aria-selected="false" tabindex="-1">Versi 2</button>
            </li>
            {{-- <li class="nav-item" role="presentation">
                <button type="button" class="nav-link waves-effect waves-light" role="tab" data-bs-toggle="tab" data-bs-target="#version-3" aria-controls="version-3" aria-selected="false" tabindex="-1">Messages</button>
            </li> --}}
        </ul>
    </div>
    <div class="tab-content" style="border-radius: none; background: none; box-shadow: none; padding: 0rem">
        <div class="tab-pane fade" id="version-1" role="tabpanel">
            <div class="row">
                <div class="col-md-7">
                    <div class="mb-4 card">
                        {{-- <h5 class="card-header d-flex justify-content-between align-items-center">Data Akun Admin</h5> --}}
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0" style="text-align: center">Data Faktur Atap</h5>
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
                                @foreach ($due_date_roof_rules as $key => $due_date_roof_rule)
                                    @if ($key == 0)
                                        @continue
                                    @endif
                                    <div class="col-4">
                                        <div class="form-label">{{ $due_date_roof_rule?->due_date }} Hari</div>
                                        <input type="text" class="form-control" value="{{ Carbon::parse($get_invoice?->date)?->addDays($due_date_roof_rule?->due_date)?->format('d M Y') }}" disabled>
                                        @error('amount')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="mb-4 card">
                        {{-- <h5 class="card-header d-flex justify-content-between align-items-center">Data Akun Admin</h5> --}}
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0" style="text-align: center">Rincian Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                @foreach ($categories as $category)
                                    <div class="col-{{ 12 / (count($categories) > 0 ? count($categories) : 1) }}">
                                        <div class="form-label">Total <b>{{ $category?->name }}</b></div>
                                        <input type="text" class="form-control" value="Rp. {{ number_format($amounts[$category?->slug], 0, ',', '.') }}" placeholder="" disabled>
                                    </div>
                                @endforeach
                                @foreach ($categories as $category)
                                    <div class="col-{{ 12 / (count($categories) > 0 ? count($categories) : 1) }}">
                                        <div class="form-label">Nominal Terbayar</div>
                                        <input type="text" class="form-control" value="{{ $payment_amounts[$category?->slug] }}" placeholder="" disabled>
                                    </div>
                                @endforeach
                                @foreach ($categories as $category)
                                    <div class="col-{{ 12 / (count($categories) > 0 ? count($categories) : 1) }}">
                                        <div class="form-label">Sisa Pembayaran</div>
                                        <input type="text" class="form-control" value="{{ $remaining_amounts[$category?->slug] }}" placeholder="" disabled>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-4 card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0" style="text-align: center">Detail Pembayaran Faktur</h5>
                            <button type="submit" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal">Tambah </button>
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
                                                @if ($result?->category)
                                                    <b>{{ $result?->category?->name }}</b>
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
                                                {{-- <button class="btn btn-info btn-sm" wire:click="detail('{{ $result?->id }}')" x-data="{ tooltip: 'Detail' }" x-tooltip="tooltip"><i class="fa-solid fa-circle-info fa-fw"></i></button> --}}
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
                        <div class="card-body">
                            <div class="row align-items-center g-3">
                                {{-- <div class="col-lg-6 col-12">Menampilkan {{ $ceramic_invoices->firstItem() }} sampai {{ $ceramic_invoices->lastItem() }} dari {{ $ceramic_invoices->total() }} hasil</div>
                                <div class="col-lg-6 col-12 text-align-end">{{ $ceramic_invoices->onEachSide(1)->links('vendor.livewire.custom-paginate') }}</div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade show active" id="version-2" role="tabpanel">
            {{-- <livewire:invoice.ceramic-invoice.ceramic-invoice-detail.ceramic-invoice-detail-v2 :id="$get_invoice?->id" wire:key="ceramic-invoice-detail-v2-{{ $get_invoice?->id }}"/> --}}
            <livewire:invoice.roof-invoice.roof-invoice-detail.roof-invoice-detail-v2 :id="$get_invoice?->id" wire:key="roof-invoice-detail-v2-{{ $get_invoice?->id }}"/>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            Livewire.on("openModal-v1", () => {
                jQuery('#modal').modal('show');
            });
            Livewire.on("closeModal", () => {
                jQuery('#modal').modal('hide');
            });
        });
    </script>
@endpush


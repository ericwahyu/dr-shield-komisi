@section('title', 'Faktur Atap')
<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    @include('livewire.invoice.roof-invoice.roof-invoice-modal')
    @include('livewire.invoice.roof-invoice.roof-invoice-modal-import')
    <div wire:loading.block wire:target="importInvoiceData">
        @include('layouts.layout.loading-screen')
    </div>
    <div class="d-flex align-items-center">
        <div>
            <h3 class="mb-0 fw-semibold">Faktur Atap</h3>
        </div>
        <div class="ms-auto">
            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-import">Import<i class="fa-solid fa-file-import fa-fw ms-2"></i></button>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">Tambah <i class="fa-solid fa-circle-plus fa-fw ms-2"></i></button>
        </div>
    </div>
    <hr class="my-3">
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-between g-3">
                <div class="col-12 col-lg-4">
                    <div class="row">
                        <div class="gap-2 col-lg-6 col-12 d-flex align-items-center">
                            <div>Lihat</div>
                            <select class="form-select" wire:model.live="perPage">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <div class="ms-auto">Hasil</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="row">
                        <div class="gap-2 col-lg-10 col-12 d-flex align-items-center">
                            <input class="form-control" type="month" wire:model.live="filter_month" id="html5-date-input">
                            <select class="form-select @error('filter_sales') is-invalid @enderror" id="status" wire:model.live="filter_sales" aria-label="Default select example">
                                <option value="" selected>-- Pilih Sales --</option>
                                @foreach ($sales as $sales)
                                    <option value="{{ $sales?->id }}" {{ $filter_sales == $sales?->id ? "selected" : "" }}>{{ Str::title($sales?->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4 text-end">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-regular fa-magnifying-glass fa-fw"></i></span>
                        <input class="form-control" type="text" placeholder="Cari Sesuatu.." wire:model.live="search">
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive scrollbar-x">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 10px;">No</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Nomor</th>
                        <th class="text-center">Pelanggan</th>
                        {{-- <th class="text-center">DPP</th>
                        <th class="text-center">Nilai PPN</th> --}}
                        <th class="text-center">Total</th>
                        <th class="text-center">Nama Penjual Utama</th>
                        {{-- <th class="text-center">ID Pelanggan</th>
                        <th class="text-center">Masa Jatuh Tempo</th> --}}
                        {{-- @foreach ($due_date_ceramic_rules as $due_date_ceramic_rule)
                            <th class="text-center">{{ $due_date_ceramic_rule?->due_date ." Hari"}}</th>
                        @endforeach --}}
                        <th class="text-center" style="width: 10px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roof_invoices as $result)
                        <tr>
                            <td class = "text-center">{{ $roof_invoices?->currentPage() * $perPage - $perPage + $loop->iteration }}</td>
                            <td class = "text-center">{{ $result?->date ? $result?->date?->format('d M Y') : '-' }}</td>
                            <td class = "text-center">{{ $result?->invoice_number ? $result?->invoice_number : '-' }}</td>
                            <td class = "text-center">{{ $result?->customer ? Str::limit($result?->customer, 20, '...') : '-' }}</td>
                            {{-- <td class = "text-center">{{ $result?->income_tax ? number_format($result?->income_tax, 0, ',', '.') : '-' }}</td>
                            <td class = "text-center">{{ $result?->value_tax ? number_format($result?->value_tax, 0, ',', '.') : '-' }}</td> --}}
                            <td class = "text-center">{{ $result?->amount ? number_format($result?->amount, 0, ',', '.') : '-' }}</td>
                            <td class = "text-center">{{ $result?->user?->userDetail?->sales_code ? $result?->user?->userDetail?->sales_code : '-' }}</td>
                            {{-- <td class = "text-center">{{ $result?->id_customer ? $result?->id_customer : '-' }}</td>
                            <td class = "text-center">{{ $result?->due_date ? $result?->due_date ." Hari": '-' }}</td> --}}
                            {{-- @foreach ($due_date_ceramic_rules as $due_date_ceramic_rule)
                                <td class="text-center">{{ $result?->date ? $result?->date?->addDays((int)$due_date_ceramic_rule?->due_date)->format('d M Y') : '-' }}</td>
                            @endforeach --}}
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm" wire:click="deleteConfirm('{{ $result?->id }}')" x-data="{ tooltip: 'Hapus' }" x-tooltip="tooltip"><i class="fa-solid fa-trash-alt"></i></button>
                                <button class="btn btn-warning btn-sm" wire:click="edit('{{ $result?->id }}')" x-data="{ tooltip: 'Edit' }" x-tooltip="tooltip"><i class="fa-solid fa-pencil-alt"></i></button>
                                {{-- <button class="btn btn-info btn-sm" wire:click="detail('{{ $result?->id }}')" x-data="{ tooltip: 'Detail' }" x-tooltip="tooltip"><i class="fa-solid fa-circle-info"></i></button> --}}
                                <a class="btn btn-info btn-sm" href="{{ route('roof.invoice.detail', $result?->id) }}" x-data="{ tooltip: 'Detail' }" x-tooltip="tooltip"><i class="fa-solid fa-circle-info"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center fw-bold">Belum Ada Data</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td class = "text-center" colspan="3" rowspan="2">Versi 1</td>
                        <td class = "text-center" colspan="1">Dr Shield</td>
                        <td class = "text-center" colspan="1"><b>{{ "Rp. " .number_format($this->sumIncomeTax(1, 'dr-shield'), 0, ',', '.') }}</b></td>
                    </tr>
                    <tr>
                        <td class = "text-center" colspan="1">Dr Sonne</td>
                        <td class = "text-center" colspan="1"><b>{{ "Rp. " .number_format($this->sumIncomeTax(1, 'dr-sonne'), 0, ',', '.') }}</b></td>
                    </tr>
                    {{-- <tr>
                        <td class = "text-center" colspan="3" rowspan="2">Versi 2</td>
                        <td class = "text-center" colspan="1">All</td>
                        <td class = "text-center" colspan="1">1.234.456</td>
                    </tr>
                    <tr>
                        <td class = "text-center" colspan="1">Dr Sonne</td>
                        <td class = "text-center" colspan="1">1.234.456</td>
                    </tr> --}}
                </tfoot>
            </table>
        </div>
        <div class="card-body">
            <div class="row align-items-center g-3">
                <div class="col-lg-6 col-12">Menampilkan {{ $roof_invoices->firstItem() }} sampai {{ $roof_invoices->lastItem() }} dari {{ $roof_invoices->total() }} hasil</div>
                <div class="col-lg-6 col-12 text-align-end">{{ $roof_invoices->onEachSide(1)->links('vendor.livewire.custom-paginate') }}</div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            Livewire.on("openModal", () => {
                jQuery('#modal').modal('show');
            });
            Livewire.on("closeModal", () => {
                jQuery('#modal').modal('hide');
            });
            Livewire.on("closeModal", () => {
                jQuery('#modal-import').modal('hide');
            });
        });
    </script>
@endpush

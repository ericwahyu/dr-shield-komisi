@section('title', 'Reset Data')
<div>
    {{-- The Master doesn't talk, he acts. --}}
    @include('livewire.setting.reset-faktur.reset-faktur-modal')
    <div wire:loading.block wire:target="saveData">
        @include('layouts.layout.loading-screen')
    </div>
    <div class="d-flex align-items-center">
        <div>
            <h3 class="mb-0 fw-semibold">Reset Data</h3>
        </div>
        <div class="ms-auto">
            {{-- <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-import">Import<i class="fa-solid fa-file-import fa-fw ms-2"></i></button> --}}
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
                        <th class="text-center">User</th>
                        <th class="text-center">Tanggal Eksekusi</th>
                        <th class="text-center">Catatan</th>
                        <th class="text-center">Data Import Reset</th>
                </thead>
                <tbody>
                    {{-- @dd($ceramic_invoices) --}}
                    @forelse ($reset_datas as $result)
                        <tr>
                            <td class = "text-center">{{ $reset_datas?->currentPage() * $perPage - $perPage + $loop->iteration }}</td>
                            <td class = "text-center">{{ $result?->user?->name }}</td>
                            <td class = "text-center">{{ $result?->date_reset ? $result?->date_reset?->format('d M Y') : '-' }}</td>
                            <td class = "text-center">{{ $result?->note ?? '-' }}</td>
                            <td class = "text-center">{{ $result?->data_reset ? $result?->data_reset?->format('d M Y') : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center fw-bold">Belum Ada Data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-body">
            <div class="row align-items-center g-3">
                {{-- <div class="col-lg-6 col-12">Menampilkan {{ $reset_datas->firstItem() }} sampai {{ $reset_datas->lastItem() }} dari {{ $reset_datas->total() }} hasil</div>
                <div class="col-lg-6 col-12 text-align-end">{{ $reset_datas->onEachSide(1)->links('vendor.livewire.custom-paginate') }}</div> --}}
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
        });
    </script>
@endpush

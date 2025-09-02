@section('title', 'Pengaturan Persentase Komisi SPV/BM')
<div>
    {{-- Do your work, then step back. --}}
    @include('livewire.setting.percentage-region-commission.percentage-region-commission-modal')
     <div class="d-flex align-items-center">
        <div>
            <h3 class="mb-0 fw-semibold">Pengaturan Persentase Komisi SPV/BM</h3>
        </div>
        <div class="ms-auto">
            {{-- <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-import">Import<i class="fa-solid fa-file-import fa-fw ms-2"></i></button> --}}
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal">Tambah <i class="fa-solid fa-circle-plus fa-fw ms-2"></i></button>
        </div>
    </div>
    <hr class="my-3">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Komisi Atap</h4>
                </div>
                <div class="table-responsive scrollbar-x">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 10px;">No</th>
                                <th class="text-center">Target Persentase Komisi</th>
                                <th class="text-center">Nilai Persentase Komisi</th>
                                <th class="text-center" style="width: 10px;">Aksi</th>
                        </thead>
                        <tbody>
                            @forelse ($percentage_roofs as $key => $result)
                                <tr>
                                    <td class = "text-center">{{ $key + 1 }}</td>
                                    {{-- <td class = "text-center"><b>{{ $result?->type == 'roof' ? 'ATAP' : 'KERAMIK' }}</b></td> --}}
                                    <td class = "text-center">{{ $result?->percentage_target ? $result?->percentage_target .' %' : '-' }}</td>
                                    <td class = "text-center">{{ $result?->percentage_commission ? $result?->percentage_commission .' %' : '-' }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-danger btn-sm" wire:click="deleteConfirm('{{ $result?->id }}')" x-data="{ tooltip: 'Hapus' }" x-tooltip="tooltip"><i class="fa-solid fa-trash-alt fa-fw"></i></button>
                                        <button class="btn btn-warning btn-sm" wire:click="edit('{{ $result?->id }}')" x-data="{ tooltip: 'Edit' }" x-tooltip="tooltip"><i class="fa-solid fa-pencil-alt fa-fw"></i></button>
                                    </td>
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
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Komisi Keramik</h4>
                </div>
                <div class="table-responsive scrollbar-x">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 10px;">No</th>
                                <th class="text-center">Target Persentase Komisi</th>
                                <th class="text-center">Nilai Persentase Komisi</th>
                                <th class="text-center" style="width: 10px;">Aksi</th>
                        </thead>
                        <tbody>
                            @forelse ($percentage_ceramics as $key => $result)
                                <tr>
                                    <td class = "text-center">{{ $key + 1 }}</td>
                                    {{-- <td class = "text-center"><b>{{ $result?->type == 'roof' ? 'ATAP' : 'KERAMIK' }}</b></td> --}}
                                    <td class = "text-center">{{ $result?->percentage_target ? $result?->percentage_target .' %' : '-' }}</td>
                                    <td class = "text-center">{{ $result?->percentage_commission ? $result?->percentage_commission .' %' : '-' }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-danger btn-sm" wire:click="deleteConfirm('{{ $result?->id }}')" x-data="{ tooltip: 'Hapus' }" x-tooltip="tooltip"><i class="fa-solid fa-trash-alt fa-fw"></i></button>
                                        <button class="btn btn-warning btn-sm" wire:click="edit('{{ $result?->id }}')" x-data="{ tooltip: 'Edit' }" x-tooltip="tooltip"><i class="fa-solid fa-pencil-alt fa-fw"></i></button>
                                    </td>
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

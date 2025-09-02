@section('title', 'Komisi SPV/BM')
<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="d-flex align-items-center">
        <div>
            <h3 class="mb-0 fw-semibold">Komisi SPV/BM</h3>
        </div>
        <div class="ms-auto">
            {{-- <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-export">Tambah <i class="fa-solid fa-circle-plus fa-fw ms-2"></i></button> --}}
            <a href="{{ route('region.commission-create') }}" class="btn btn-success" >Tambah <i class="fa-solid fa-circle-plus fa-fw ms-2"></i></a>
        </div>
    </div>
    <hr class="my-3">
    <div class="card">
        <div class="table-responsive scrollbar-x">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 10px;">No</th>
                            <th class="text-center">Pembuat</th>
                            <th class="text-center">Bulan</th>
                            <th class="text-center" style="width: 10px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $key => $result)
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $this->getUser($result)?->name ?? '-' }}</td>
                            <td class="text-center">{{ $key }}</td>
                            <td class="text-center">
                                {{-- <button class="btn btn-danger btn-sm" wire:click="deleteConfirm('{{ $result?->id }}')" x-data="{ tooltip: 'Hapus' }" x-tooltip="tooltip"><i class="fa-solid fa-trash-alt fa-fw"></i></button>
                                <button class="btn btn-warning btn-sm" wire:click="edit('{{ $result?->id }}')" x-data="{ tooltip: 'Edit' }" x-tooltip="tooltip"><i class="fa-solid fa-pencil-alt fa-fw"></i></button> --}}
                                <a href="{{ route('region.commission-detail', "$key") }}" class="btn btn-info btn-sm" x-data="{ tooltip: 'Lihat Detail' }" x-tooltip="tooltip"><i class="fa-solid fa-circle-info fa-fw"></i></a>
                                {{-- @if ($result?->userDetail?->sales_type  == 'roof')
                                @endif --}}
                            </td>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center fw-bold">Belum Ada Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
    </div>
</div>

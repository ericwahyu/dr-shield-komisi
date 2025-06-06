@section('title', 'Target Aktual Atap')
@php
    use Illuminate\Support\Str;
@endphp
<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    @include('livewire.commission.actual-target.actual-target-modal')
    <div class="d-flex align-items-center">
        <div>
            <h3 class="mb-0 fw-semibold">Target Aktual Atap</h3>
        </div>
        <div class="ms-auto">
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
                {{-- <div class="col-12 col-lg-3">
                    <div class="row">
                        <div class="gap-2 col-lg-10 col-12 d-flex align-items-center">
                            <input class="form-control" type="month" wire:model.live="filter_month" id="html5-date-input">
                        </div>
                    </div>
                </div> --}}
                <div class="col-12 col-lg-3 text-end">
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
                        <th rowspan="2" class="text-center">Kategori</th>
                        <th rowspan="2" class="text-center">Target</th>
                        @foreach ($actuals as $actual)
                            <th colspan="2" class="text-center">{{ Str::title(Str::replace('-', ' ', $actual)) }} %</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($actuals as $actual)
                            <th class="text-center">Nominal</th>
                            <th class="text-center" style="width: 10px;">Aksi</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        @php
                            $targets = $this->getTargets($category);
                            // @dd(count($targets) > 0 )
                        @endphp
                        <tr>
                            <td rowspan="{{ count($targets) > 0 ? count($targets) : 1 }}" class="text-center"><b>{{ Str::title(Str::replace('-', ' ', $category)) }}</b></td>
                            <td class="text-center">Rp. {{ count($targets) > 0 ? number_format($targets[0], 0, ',', '.') : '-' }}</td>
                            @foreach ($actuals as $actual)
                                <td class="text-center"> {{ count($targets) > 0 ? "Rp. ".number_format($this->getActualTarget($category, $actual, $targets[0])?->value_commission, 0, ',', '.') : '-' }}</td>
                                <td class="text-center">
                                    @if (count($targets) > 0 && $this->getActualTarget($category, $actual, $targets[0]) != null)
                                        <button class="btn btn-danger btn-sm" wire:click="deleteConfirm('{{ $category }}', {{ $actual }}, {{ $targets[0] }})" x-data="{ tooltip: 'Hapus' }" x-tooltip="tooltip"><i class="fa-solid fa-trash-alt fa-fw"></i></button>
                                        <button class="btn btn-warning btn-sm" wire:click="edit('{{ $category }}', {{ $actual }}, {{ $targets[0] }})" x-data="{ tooltip: 'Edit' }" x-tooltip="tooltip"><i class="fa-solid fa-pencil-alt fa-fw"></i></button>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        @foreach ($targets as $key => $target)
                            @if ($key > 0)
                                <tr>
                                    <td class="text-center">Rp. {{ number_format($target, 0, ',', '.') }}</td>
                                    @foreach ($actuals as $actual)
                                        <td class="text-center">Rp. {{ number_format($this->getActualTarget($category, $actual, $target)?->value_commission, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            @if ($this->getActualTarget($category, $actual, $target) != null)
                                                <button class="btn btn-danger btn-sm" wire:click="deleteConfirm('{{ $category }}', {{ $actual }}, {{ $target }})" x-data="{ tooltip: 'Hapus' }" x-tooltip="tooltip"><i class="fa-solid fa-trash-alt fa-fw"></i></button>
                                                <button class="btn btn-warning btn-sm" wire:click="edit('{{ $category }}', {{ $actual }}, {{ $target }})" x-data="{ tooltip: 'Edit' }" x-tooltip="tooltip"><i class="fa-solid fa-pencil-alt fa-fw"></i></button>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endif
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="100" class="text-center fw-bold">Belum Ada Data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-body">
            <div class="row align-items-center g-3">
                {{-- <div class="col-lg-6 col-12">Menampilkan {{ $sales->firstItem() }} sampai {{ $sales->lastItem() }} dari {{ $sales->total() }} hasil</div>
                <div class="col-lg-6 col-12 text-align-end">{{ $sales->onEachSide(1)->links('vendor.livewire.custom-paginate') }}</div> --}}
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


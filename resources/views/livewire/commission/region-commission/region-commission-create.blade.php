@section('title', 'Komisi SPV/BM')
<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
     <div class="d-flex align-items-center">
        <a href="{{ route('region.commission') }}" class="btn btn-icon" style="margin-right: 15px"><i class="fa-solid fa-arrow-left"></i></a>
        <div>
            <h3 class="fw-semibold mb-0">Buat Komisi SPV/BM</h3>
        </div>
        <div class="ms-auto">
            {{-- <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-export">Tambah <i class="fa-solid fa-circle-plus fa-fw ms-2"></i></button> --}}
            <a href="#" class="btn btn-success" wire:click='generate'>Generate <i class="fa-solid fa-circle-plus fa-fw ms-2"></i></a>
        </div>
    </div>
    <hr class="my-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="generate_month" class="form-label">Bulan Tahun <span class="text-danger">*</span></label>
                        <input type="month" class="form-control @error('generate_month') is-invalid @enderror" id="generate_month" wire:model="generate_month">
                        @error('generate_month')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Komisi Atap</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="roof_region_select" class="form-label">Wilayah <span class="text-danger">*</span></label>
                                <select class="form-select @error('roof_region_select') is-invalid @enderror" id="roof_region_select" wire:model="roof_region_select" aria-label="Default select example">
                                    <option selected value="" style="display: none">Pilih Wilayah</option>
                                    @foreach ($roof_region as $roof_region)
                                        <option value="{{ $roof_region }}">{{ $roof_region }}</option>
                                    @endforeach
                                    {{-- <option value="perempuan">Perempuan</option> --}}
                                </select>
                                @error('roof_region_select')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="roof_target" class="form-label">Nominal Target 100% <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('roof_target') is-invalid @enderror" id="roof_target" wire:model="roof_target">
                                @error('roof_target')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">&nbsp;</label>
                                <div>
                                    <button wire:click="addDataRegion('roof')"" class="btn btn-success py-3">Tambah</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                    @error('data_roof_region')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Wilayah</th>
                                <th>Target 100%</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($data_roof_region as $key => $data_roof_region)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ $data_roof_region[100] ?? '-' }}</td>
                                    <td>
                                        <button class="btn text-danger" wire:click="removeDataRegion('roof', '{{ $key }}')" x-data="{ tooltip: 'Hapus' }" x-tooltip="tooltip"><i class="fa-solid fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Komisi Keramik</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="ceramic_region_select" class="form-label">Wilayah <span class="text-danger">*</span></label>
                                <select class="form-select @error('ceramic_region_select') is-invalid @enderror" id="ceramic_region_select" wire:model="ceramic_region_select" aria-label="Default select example">
                                    <option selected value="" style="display: none">Pilih Wilayah</option>
                                    @foreach ($ceramic_region as $ceramic_region)
                                        <option value="{{ $ceramic_region }}">{{ $ceramic_region }}</option>
                                    @endforeach
                                    {{-- <option value="perempuan">Perempuan</option> --}}
                                </select>
                                @error('ceramic_region_select')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="mb-3">
                                <label for="ceramic_target" class="form-label">Nominal Target 100% <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('ceramic_target') is-invalid @enderror" id="ceramic_target" wire:model="ceramic_target">
                                @error('ceramic_target')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">&nbsp;</label>
                                <div>
                                    <button wire:click="addDataRegion('ceramic')"" class="btn btn-success py-3">Tambah</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive text-nowrap">
                    @error('data_ceramic_region')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Wilayah</th>
                                <th>Target 100%</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($data_ceramic_region as $key => $data_ceramic_region)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ $data_ceramic_region[100] ?? '-' }}</td>
                                    <td>
                                        <button class="btn text-danger" wire:click="removeDataRegion('ceramic', '{{ $key }}')" x-data="{ tooltip: 'Hapus' }" x-tooltip="tooltip"><i class="fa-solid fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

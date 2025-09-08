<div class="modal fade modal-lg" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Form Reset Faktur</h1>
                <button type="button" class="btn-close" wire:click="closeModal()"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-label">Bulan yang akan di reset (invoice, pembayaran, komisi)<span class="text-danger">*</span></div>
                        <input type="month" class="form-control @error('data_reset') is-invalid @enderror" wire:model="data_reset" placeholder="">
                        @error('data_reset')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <div class="form-label">Pilih Sales <span class="text-danger">*</span></div>
                        <div x-data="{ openSecondary: @entangle('open_sales_secondary') }"
                            x-on:click.away="openSecondary = false"
                            class="position-relative">

                            <div class="input-group">
                                <input type="text" class="form-control"
                                    placeholder="Cari Sales Pendamping..."
                                    wire:model.live="sales_secondary"
                                    x-on:focus="openSecondary = true">

                                @if($selected_sales_secondary)
                                    <button type="button" class="input-group-text btn" wire:click="clearSecondary">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                @endif
                            </div>

                            <div x-show="openSecondary" class="dropdown-sales-results">
                                <ul class="list-unstyled mb-0">
                                    @forelse ($list_secondary as $sales)
                                        <li wire:key="secondary-{{ $sales->id }}"
                                            wire:click="selectSecondary('{{ $sales->id }}')"
                                            x-on:click="openSecondary = false"
                                            class="dropdown-sales-item {{ $selected_sales_secondary?->id === $sales->id ? 'active' : '' }}">
                                            <strong>{{ $sales->name }}</strong><br>
                                            <small class="text-muted">{{ $sales->userDetail?->depo }} • {{ $sales?->userDetail?->sales_type == 'roof' ? "Atap" : "Keramik" }}</small>
                                        </li>
                                    @empty
                                        <li class="px-3 py-2 text-muted">Tidak ada hasil</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                        @error('sales_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" wire:click="closeModal()">Tutup <i class="fa-solid fa-circle-xmark fa-fw ms-2"></i></button>
                <button type="button" class="btn btn-success btn-sm" wire:click="saveData()">Simpan <i class="fa-solid fa-circle-check fa-fw ms-2"></i></button>
            </div>
        </div>
    </div>
</div>

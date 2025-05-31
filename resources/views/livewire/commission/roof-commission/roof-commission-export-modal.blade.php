<div class="modal fade modal-md" id="modal-export" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Export Komisi Atap</h1>
                <button type="button" class="btn-close" wire:click="closeModal()"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="form-label">Pilih Versi <span class="text-danger">*</span></div>
                        <select class="form-select @error('export_version') is-invalid @enderror" id="status" wire:model="export_version" aria-label="Default select example">
                            <option value=""selected style="display: none">-- Pilih Versi --</option>
                            {{-- <option value="roof" {{ $export_version == 1 ? "selected" : "" }}>Versi 1</option> --}}
                            <option value="2" selected >Versi 2</option>
                        </select>
                        @error('export_version')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <div class="form-label">Bulan <span class="text-danger">*</span></div>
                        <input type="month" class="form-control @error('export_month') is-invalid @enderror" wire:model.live="export_month">
                        @error('export_month')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" wire:click="closeModal()">Tutup <i class="fa-solid fa-circle-xmark fa-fw ms-2"></i></button>
                <button type="button" class="btn btn-success btn-sm" wire:click="exportData()">Export <i class="fa-solid fa-circle-check fa-fw ms-2"></i></button>
            </div>
        </div>
    </div>
</div>

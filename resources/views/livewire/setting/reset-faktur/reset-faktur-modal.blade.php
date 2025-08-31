<div class="modal fade modal-lg" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
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
                         <select class="form-select @error('type') is-invalid @enderror" id="status" wire:model="sales_id" aria-label="Default select example">
                            <option value=""selected style="display: none">-- Pilih sales  --</option>
                            @foreach ($sales as $sales)
                                <option value="{{ $sales?->id }}">{{ Str::title($sales?->name) }}</option>
                            @endforeach
                        </select>
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

<div class="modal fade modal-lg" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Form Pengguna</h1>
                <button type="button" class="btn-close" wire:click="closeModal()"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="form-label">Nama <span class="text-danger">*</span></div>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name" placeholder="Contoh : Eric Wahyu Amiruddin">
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <div class="form-label">Email <span class="text-danger">*</span></div>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email" placeholder="Contoh : ericwa11@gmail.com">
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <div class="form-label">Username <span class="text-danger">*</span></div>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" wire:model="username" placeholder="Contoh : ericwa">
                        @error('username')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <div class="form-label">Password <span class="text-danger">*</span></div>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" wire:model="password" placeholder="">
                        @error('password')
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

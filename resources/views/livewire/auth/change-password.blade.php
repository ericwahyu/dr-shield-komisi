<div>
    {{-- In work, do what you enjoy. --}}
    <div class="modal fade" id="modal-change-password" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Form Ubah Kata Sandi</h1>
                    <button type="button" class="btn-close" wire:click="closeModalChangePassword()"></button>
                </div>
                <form action="" wire:submit="saveChangePassword()">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-label">Kata Sandi Lama <span class="text-danger">*</span></div>
                                <input type="password" id="old_password" class="form-control @error('old_password') is-invalid @enderror" wire:model="datas.old_password">
                                @error('datas.old_password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="form-label">Kata Sandi Baru <span class="text-danger">*</span></div>
                                <input type="password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" wire:model="datas.new_password">
                                @error('datas.new_password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="form-label">Konfirmasi Kata Sandi Baru <span class="text-danger">*</span></div>
                                <input type="password" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" wire:model="datas.password_confirmation">
                                @error('datas.password_confirmation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="closeModalChangePassword()">Tutup <i class="fa-solid fa-circle-xmark fa-fw ms-2"></i></button>
                        <button type="submit" class="btn btn-success btn-sm">Simpan <i class="fa-solid fa-circle-check fa-fw ms-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            Livewire.on("openModalChangePassword", () => {
                jQuery('#modal-change-password').modal('show');
            });
            Livewire.on("closeModalChangePassword", () => {
                jQuery('#modal-change-password').modal('hide');
            });
        });
    </script>
@endpush


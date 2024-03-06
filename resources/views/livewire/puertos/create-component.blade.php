<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">CREAR PUERTO </h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Puertos</a></li>
                    <li class="breadcrumb-item active">Crear puerto</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->

    <div class="row">
        <div class="col-md-9">
            <div class="card m-b-30">
                <div class="card-body">
                    <form wire:submit.prevent="submit">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="Nombre" class="col-form-label">Nombre</label>
                                <input type="text" wire:model="Nombre" class="form-control" id="Nombre" placeholder="Nombre del Puerto">
                                @error('Nombre') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="Pais" class="col-form-label">Pais</label>
                                <input type="text" wire:model="Pais" class="form-control" id="Pais" placeholder="Pais del Puerto">
                                @error('Pais') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card m-b-30">
                <div class="card-body">
                    <h5>Acciones</h5>
                    <div class="row">
                        <div class="col-12">
                            <button class="w-100 btn btn-success mb-2" id="alertaGuardar">Guardar
                                Puerto</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script>
    $("#alertaGuardar").on("click", () => {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Pulsa el botón de confirmar para guardar el puerto.',
            icon: 'warning',
            showConfirmButton: true,
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.livewire.emit('submit');
            }
        });
    });
</script>
@endsection

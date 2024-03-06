<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">CREAR CLIENTE DESDE PRESUPUESTO @if(session('datos')) {{session('datos')['nPresupuesto']}}@endif</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Presupuesto</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Crear presupuesto</a></li>
                    <li class="breadcrumb-item active">Crear cliente desde presupuesto</li>
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
                                <label for="nombre" class="col-form-label">Nombre</label>
                                <input type="text" wire:model="nombre" class="form-control" id="nombre" placeholder="Nombre">
                                @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="email1" class="col-form-label">Email</label>
                                <input type="email" wire:model="email" class="form-control" id="email1" placeholder="Email">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="telefono" class="col-form-label">Teléfono</label>
                                <input type="text" wire:model="telefono" class="form-control" id="telefono" placeholder="Teléfono">
                                @error('telefono') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="direccion" class="col-form-label">Dirección</label>
                                <input type="text" wire:model="direccion" class="form-control" id="direccion" placeholder="Dirección">
                                @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror
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
                                Cliente</button>
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
            text: 'Pulsa el botón de confirmar para guardar el cliente.',
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


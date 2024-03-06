
<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">EDITAR PROVEEDOR <span style="text-transform: uppercase">{{$nombre}}</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Proveedores</a></li>
                    <li class="breadcrumb-item active">Editar Proveedor {{$nombre}}</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->

    <div class="row">
        <div class="col-md-9">
            <div class="card m-b-30">
                <div class="card-body">
                    <form wire:submit.prevent="update">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="nombre" class="col-form-label">Nombre</label>
                                <input type="text" wire:model="nombre" class="form-control" id="nombre" placeholder="Nombre de empresa">
                                @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="contacto" class="col-form-label">Contacto</label>
                                <input type="text" wire:model="contacto" class="form-control" id="contacto" placeholder="Nombre de contacto">
                                @error('contacto') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="direccion" class="col-form-label">Dirección</label>
                                <input type="text" wire:model="direccion" class="form-control" id="direccion" placeholder="Dirección">
                                @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="email1" class="col-form-label">Email</label>
                                <input type="email" wire:model="email" class="form-control" id="email1" placeholder="Email">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="telefono" class="col-form-label">Teléfono</label>
                                <input type="text" wire:model="telefono" class="form-control" id="telefono" placeholder="Teléfono">
                                @error('telefono') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label for="gastos_llegada" class="col-form-label">Gastos de llegada 20</label>
                                <input type="number" wire:model="gastos_llegada" class="form-control" id="gastos_llegada_20" placeholder="Gastos de llegada">
                                @error('gastos_llegada') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-sm-3">
                                <label for="gastos_llegada" class="col-form-label">Gastos de llegada 40</label>
                                <input type="number" wire:model="gastos_llegada" class="form-control" id="gastos_llegada_40" placeholder="Gastos de llegada">
                                @error('gastos_llegada') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-sm-3">
                                <label for="gastos_llegada" class="col-form-label">Gastos de llegada HQ</label>
                                <input type="number" wire:model="gastos_llegada" class="form-control" id="gastos_llegada_h4" placeholder="Gastos de llegada">
                                @error('gastos_llegada') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-sm-3">
                                <label for="gastos_llegada" class="col-form-label">Gastos de llegada Grupage</label>
                                <input type="number" wire:model="gastos_llegada" class="form-control" id="gastos_llegada_grupage" placeholder="Gastos de llegada">
                                @error('gastos_llegada') <span class="text-danger">{{ $message }}</span> @enderror
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
                            <button class="w-100 btn btn-success mb-2" type="button" wire:click="update">Actualizar Proveedor</button>
                            <button class="w-100 btn btn-danger mb-2" type="button" id="alertaEliminar">Eliminar Proveedor</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@section('scripts')
<script>
$("#alertaEliminar").on("click", () => {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Pulsa el botón de confirmar para eliminar los datos del Proveedor. Esto es irreversible.',
                icon: 'error',
                showConfirmButton: true,
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.livewire.emit('confirmDelete');
                }
            });
        });
</script>
@endsection

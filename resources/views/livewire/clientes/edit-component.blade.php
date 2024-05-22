
<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">EDITAR CLIENTE <span style="text-transform: uppercase">{{$nombre}}</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Clientes</a></li>
                    <li class="breadcrumb-item active">Editar Cliente {{$nombre}}</li>
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
                                <label for="empresa" class="col-form-label">Empresa</label>
                                <input type="text" wire:model="empresa" class="form-control" id="empresa" placeholder="Nombre de Empresa">
                                @error('empresa') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="nombre" class="col-form-label">Nombre de contacto</label>
                                <input type="text" wire:model="nombre" class="form-control" id="nombre" placeholder="Nombre de contacto">
                                @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="cif" class="col-form-label">CIF/DNI</label>
                                <input type="text" wire:model="cif" class="form-control" id="cif" placeholder="CIF/DNI">
                                @error('cif') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="direccion" class="col-form-label">Dirección</label>
                                <input type="text" wire:model="direccion" class="form-control" id="direccion" placeholder="Dirección">
                                @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="telefono" class="col-form-label">Teléfono</label>
                                <input type="text" wire:model="telefono" class="form-control" id="telefono" placeholder="Teléfono">
                                @error('telefono') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="email" class="col-form-label">Email</label>
                                <input type="text" wire:model="email" class="form-control" id="email" placeholder="Email">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="seguro" class="col-form-label">Seguro</label>
                                <input type="text" wire:model="seguro" class="form-control" id="seguro" placeholder="Seguro">
                                @error('seguro') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="pago" class="col-form-label">Metodo de pago</label>
                                <input type="text" wire:model="pago" class="form-control" id="pago" placeholder="Pago">
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <table class="table table-bordered dt-responsive nowrap" style="width: 100%;">
                            <thead>
                                <tr class="thead-light">
                                    <th colspan="3">Notas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notas as $index => $nota)
                                <tr>
                                    <td><input type="text" class="form-control" wire:model="notas.{{ $index }}.titulo" placeholder="Concepto"></td>
                                    <td><textarea class="form-control" wire:model="notas.{{ $index }}.descripcion" placeholder="Descripción" rows="1"></textarea></td>
                                    <td><button class="btn btn-danger" wire:click.prevent="eliminarNotas({{ $index }})">Eliminar</button></td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3"><button class="btn btn-primary w-100" wire:click.prevent="agregarNotas">Agregar Notas</button></td>
                                </tr>
                            </tbody>

                            <thead>
                                <tr class="thead-light">
                                    <th colspan="3">Gastos Aduana</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gastosAduanas as $index => $gastosAduana)
                                <tr>
                                    <td><input type="text" class="form-control" wire:model="gastosAduanas.{{ $index }}.titulo" placeholder="Concepto"></td>
                                    <td><textarea class="form-control" wire:model="gastosAduanas.{{ $index }}.descripcion" placeholder="Descripción" rows="1"></textarea></td>
                                    <td><button class="btn btn-danger" wire:click.prevent="eliminarGastosAduanas({{ $index }})">Eliminar</button></td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3"><button class="btn btn-primary w-100" wire:click.prevent="agregarGastosAduanas">Agregar Gastos Aduana</button></td>
                                </tr>
                            </tbody>

                            <thead>
                                <tr class="thead-light">
                                    <th colspan="3">Tarifa Terrestre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tarifasTerrestres as $index => $tarifasTerrestre)
                                <tr>
                                    <td><input type="text" class="form-control" wire:model="tarifasTerrestres.{{ $index }}.destino" placeholder="Destino"></td>
                                    <td><textarea class="form-control" wire:model="tarifasTerrestres.{{ $index }}.precio" placeholder="Precio" rows="1"></textarea></td>
                                    <td><button class="btn btn-danger" wire:click.prevent="eliminarTarifasTerrestres({{ $index }})">Eliminar</button></td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3"><button class="btn btn-primary w-100" wire:click.prevent="agregarTarifasTerrestres">Agregar Tarifa Terrestre</button></td>
                                </tr>
                            </tbody>
                        </table>
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
                            <button class="w-100 btn btn-success mb-2" type="button" wire:click="update">Actualizar Cliente</button>
                            <button class="w-100 btn btn-danger mb-2" type="button" id="alertaEliminar">Eliminar Cliente</button>
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
                text: 'Pulsa el botón de confirmar para eliminar los datos del cliente. Esto es irreversible.',
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

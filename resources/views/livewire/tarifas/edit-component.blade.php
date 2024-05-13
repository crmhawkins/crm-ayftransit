<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">EDITAR TARIFA</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Tarifas</a></li>
                    <li class="breadcrumb-item active">Editar Tarifa</li>
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
                            <div class="col-sm-4">
                                <label>Tipo de Tarifa:</label>
                                <div class="d-flex align-items-center mt-2">
                                    <div class="form-check mr-3">
                                        <input class="form-check-input" type="radio" wire:model="tipo_mar_area_terr" value="{{1}}" id="maritima">
                                        <label class="form-check-label" for="maritima">
                                            Marítima
                                        </label>
                                    </div>
                                    <div class="form-check mr-3">
                                        <input class="form-check-input" type="radio" wire:model="tipo_mar_area_terr" value="{{3}}" id="terrestre">
                                        <label class="form-check-label" for="terrestre">
                                            Terrestre
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" wire:model="tipo_mar_area_terr" value="{{2}}" id="aerea">
                                        <label class="form-check-label" for="aerea">
                                            Aérea
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @if ($tipo_mar_area_terr == 1|| $tipo_mar_area_terr == 2 )
                                <div class="col-sm-4">
                                    <label>Operación:</label>
                                    <div class="d-flex align-items-center mt-2">
                                        <div class="form-check mr-3">
                                            <input class="form-check-input" type="radio" wire:model="tipo_imp_exp" value="{{2}}" id="exportacion">
                                            <label class="form-check-label" for="exportacion">
                                                Exportación
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" wire:model="tipo_imp_exp" value="{{1}}" id="importacion">
                                            <label class="form-check-label" for="importacion">
                                                Importación
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @if ($tipo_mar_area_terr == 1)
                                    <div class="col-sm-4">
                                        <label>Modalidad Marítima:</label>
                                        <div class="d-flex align-items-center mt-2">
                                            <div class="form-check mr-3">
                                                <input class="form-check-input" type="radio" wire:model="tipo_cont_grup" value="{{2}}" id="Gupage">
                                                <label class="form-check-label" for="Gupage">
                                                    Gupage
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" wire:model="tipo_cont_grup" value="{{1}}" id="Contenedor">
                                                <label class="form-check-label" for="Contenedor">
                                                    Contenedor
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @elseif($tipo_mar_area_terr == 3)
                                <div class="col-sm-4">
                                    <label for="destinoterrestre" class="col-form-label">Destino</label>
                                    <input type="text" wire:model="destinoterrestre" class="form-control" id="destinoterrestre" placeholder="Destino">
                                    @error('destinoterrestre') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-sm-4">
                                    <label for="precio_terrestre" class="col-form-label">Precio</label>
                                    <input type="number" wire:model="precio_terrestre" class="form-control" id="precio_terrestre" placeholder="Precio">
                                    @error('precio_terrestre') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            @endif
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="nombre" class="col-form-label">Proveedor/Naviera</label>
                                <select class="form-control" name="proveedor_id" id="proveedor_id"
                                wire:model="proveedor_id">
                                <option value="0">-- ELIGE UN NAVIERA --</option>
                                @foreach ($Proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}">
                                                {{ $proveedor->nombre }}
                                            </option>
                                        @endforeach
                            </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="efectividad" class="col-form-label">Efectiva desde:</label>
                                <input type="date" wire:model="efectividad" class="form-control" id="efectividad" placeholder="Fecha de inicio de tarifa">
                                @error('efectividad') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-sm-4">
                                <label for="validez" class="col-form-label">Válido hasta:</label>
                                <input type="date" wire:model="validez" class="form-control" id="validez" placeholder="Fecha de fin de tarifa">
                                @error('validez') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        @if ($tipo_mar_area_terr == 1)
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label for="nombre" class="col-form-label">Origen</label>
                                    <select class="form-control" name="origen_id" id="origen_id"
                                    wire:model="origen_id">
                                    <option value="0">-- ELIGE UN PUERTO DE ORIGEN --</option>
                                    @foreach ($Puertos as $puerto)
                                                <option value="{{ $puerto->id }}">
                                                    {{ $puerto->Nombre }}-{{ $puerto->Pais }}
                                                </option>
                                            @endforeach
                                </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="nombre" class="col-form-label">Destino</label>
                                    <select class="form-control" name="destino_id" id="destino_id"
                                            wire:model="destino_id">
                                        <option value="0">-- ELIGE UN PUERTO DE DESTINO --</option>
                                        @foreach ($Puertos as $puerto)
                                            <option value="{{ $puerto->id }}">
                                                {{ $puerto->Nombre }}-{{ $puerto->Pais }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label for="nombre" class="col-form-label">Dias</label>
                                    <input type="text" wire:model="dias" class="form-control" id="dias" placeholder="Dias">
                                </div>
                            </div>
                            @if ($tipo_cont_grup == 1)
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label for="precio_contenedor_20" class="col-form-label">Precio para Contenedor 20 </label>
                                        <input type="number" wire:model="precio_contenedor_20" class="form-control" id="precio_contenedor_20" placeholder="Precio para 20">
                                        @error('gastos_llegada') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="precio_contenedor_40" class="col-form-label">Precio para Contenedor 40 </label>
                                        <input type="number" wire:model="precio_contenedor_40" class="form-control" id="precio_contenedor_40" placeholder="Precio para 40">
                                        @error('gastos_llegada') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="precio_contenedor_h4" class="col-form-label">Precio para Contenedor 4H </label>
                                        <input type="number" wire:model="precio_contenedor_h4" class="form-control" id="precio_contenedor_h4" placeholder="Precio para 4H">
                                        @error('gastos_llegada') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            @elseif($tipo_cont_grup == 2 )
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label for="precio_grupage" class="col-form-label">Precio de Grupage</label>
                                        <input type="number" wire:model="precio_grupage" class="form-control" id="precio_grupage" placeholder="Precio de Grupage">
                                        @error('gastos_llegada') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            @endif
                        @endif
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
                            <button class="w-100 btn btn-success mb-2" type="button" id="alertaGuardar">Guardar Tarifa</button>
                            <button class="w-100 btn btn-danger mb-2" type="button" id="alertaEliminar">Eliminar Tarifa</button>
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
            text: 'Pulsa el botón de confirmar actualizar la tarifa.',
            icon: 'warning',
            showConfirmButton: true,
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.livewire.emit('update');
            }
        });
    });
</script>

<script>
$("#alertaEliminar").on("click", () => {
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Pulsa el botón para eliminar la tarifa. Esto es irreversible.',
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



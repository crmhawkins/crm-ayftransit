<div class="container-fluid">
    <script src="//unpkg.com/alpinejs" defer></script>
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">EDITAR PRESUPUESTO {{ $identificador }}</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Presupuestos</a></li>
                    <li class="breadcrumb-item active">Editar Presupuesto</li>
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
                        <div class="form-row mb-4 ">
                            <div class="form-group col-md-12">
                                <h5 class="ms-3" style="border-bottom: 1px gray solid !important; padding-bottom: 10px !important;">Datos del presupuesto</h5>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="fechaEmision">Fecha de emisión</label>
                                <input type="date" wire:model="fechaEmision" class="form-control"
                                    name="fechaEmision" id="fechaEmision" placeholder="X">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="fechaVencimiento">Estado</label>
                                <select class="form-control" name="estado" id="estado" wire:model="estado">
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Cancelado">Cancelado</option>
                                    <option value="Aceptado">Aceptado</option>
                                    <option value="Completado">Completado</option>
                                    <option value="Facturado">Facturado</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6" wire:ignore>
                                <label for="Cliente">Selecciona un cliente</label>
                                <select data-pharaonic="select2"
                                        data-component-id="{{ $this->id }}"
                                        class="form-control"
                                        name="id_cliente"
                                        id="id_cliente"
                                        wire:model="id_cliente">
                                    <option value="0">-- ELIGE UN CLIENTE --</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">
                                            {{ $cliente->empresa }}-{{ $cliente->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="destino">Selecciona un destino terrestre</label>
                                <select class="form-control" name="destino" id="destino"
                                    wire:model="destino" wire:change="cambioDestino()">
                                    <option value="0">-- ELIGE UN DESTINO --</option>
                                    @if (isset($tarifasTerrestres))
                                        @foreach ($tarifasTerrestres as $tarifa)
                                            <option value="{{ $tarifa->id }}">
                                                {{ $tarifa->destino }}

                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label>Operación:</label>
                                <div class="d-flex align-items-center mt-2">
                                    <div class="form-check mr-3">
                                        <input class="form-check-input" type="radio" wire:model="tipo_imp_exp" value="2" id="exportacion">
                                        <label class="form-check-label" for="exportacion">
                                            Exportación
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" wire:model="tipo_imp_exp" value="1" id="importacion">
                                        <label class="form-check-label" for="importacion">
                                            Importación
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <label>Tipo de cotización:</label>
                                <div class="d-flex align-items-center mt-2">
                                    <div class="form-check mr-3">
                                        <input class="form-check-input" type="radio" wire:model="tipo_mar_area_terr" value="1" id="maritima">
                                        <label class="form-check-label" for="maritima">
                                            Marítima
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" wire:model="tipo_mar_area_terr" value="2" id="aerea">
                                        <label class="form-check-label" for="aerea">
                                            Aérea
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label>Modalidad Marítima:</label>
                                <div class="d-flex align-items-center mt-2">
                                    <div class="form-check mr-3">
                                        <input class="form-check-input" type="radio" wire:model="tipo_cont_grup" value="2" id="Gupage">
                                        <label class="form-check-label" for="Gupage">
                                            Gupage
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" wire:model="tipo_cont_grup" value="1" id="Contenedor">
                                        <label class="form-check-label" for="Contenedor">
                                            Contenedor
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <h5 class="ms-3" style="border-bottom: 1px gray solid !important; padding-bottom: 10px !important;">Flete Marítimo Puerto - Puerto</h5>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="filtrar">Filtrar por</label>
                                <select class="form-control" name="filtrar" id="filtrar" wire:model="filtrar">
                                    <option value="precio">Economico</option>
                                    <option value="dias">Rapido</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2" wire:ignore>
                                <label for="origen">Origen</label>
                                <select data-pharaonic="select2"
                                        data-component-id="{{ $this->id }}"
                                        class="form-control"
                                        name="origen_id"
                                        id="origen_id"
                                        wire:model="origen_id">
                                    <option value="0">ELIGE ORIGEN</option>
                                    @foreach ($puertos as $puerto)
                                        <option value="{{ $puerto->id }}">
                                            {{ $puerto->Nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2" wire:ignore>
                                <label for="destino">Destino</label>
                                <select data-pharaonic="select2"
                                        data-component-id="{{ $this->id }}"
                                        class="form-control"
                                        name="destino_id"
                                        id="destino_id"
                                        wire:model="destino_id">
                                    <option value="0">ELIGE DESTINO</option>
                                    @foreach ($puertos as $puerto)
                                        <option value="{{ $puerto->id }}">
                                            {{ $puerto->Nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($tipo_cont_grup == 1)
                            <div class="form-group col-md-6">
                                <label for="id_proveedor">Selecciona una naviera</label>
                                <select class="form-control" name="id_proveedor" id="id_proveedor"
                                        wire:model="selectProveedorTarifa">
                                    <option value="0">-- ELIGE UNA NAVIERA --</option>
                                    @foreach ($TarifasProveedores as $tarifa)
                                        <option value="{{ $tarifa->proveedor->id }}-{{ $tarifa->id }}">
                                            {{ $tarifa->proveedor->nombre }}
                                            @if (isset($tarifa->precio_total_20)) -- ${{ $tarifa->precio_total_20 }} @endif
                                            @if (isset($tarifa->precio_total_40)) -- ${{ $tarifa->precio_total_40 }} @endif
                                            @if (isset($tarifa->precio_total_h4)) -- ${{ $tarifa->precio_total_h4 }} @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @elseif($tipo_cont_grup == 2)
                            <div class="form-group col-md-6">
                                <label for="id_proveedor">Selecciona una naviera</label>
                                <select class="form-control" name="id_proveedor" id="id_proveedor"
                                        wire:model="selectProveedorTarifa">
                                    <option value="0">-- ELIGE UNA NAVIERA --</option>
                                    @foreach ($TarifasProveedores as $tarifa)
                                        <option value="{{ $tarifa->proveedor->id }}-{{ $tarifa->id }}">
                                            {{ $tarifa->proveedor->nombre }}
                                            @if (isset($tarifa->precio_total_grupage)) -- ${{ $tarifa->precio_total_grupage }} @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @else
                            <div class="form-group col-md-6">
                                <label for="id_proveedor">Selecciona una naviera</label>
                                <select class="form-control" name="id_proveedor" id="id_proveedor"
                                        wire:model="selectProveedorTarifa">
                                    <option value="0">-- ELIGE UNA NAVIERA --</option>
                                    @foreach ($TarifasProveedores as $tarifa)
                                        <option value="{{ $tarifa->proveedor->id }}-{{ $tarifa->id }}">
                                            {{ $tarifa->proveedor->nombre }}
                                            @if (isset($tarifa->precio_total_grupage)) -- ${{ $tarifa->precio_total_grupage }} @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="col-2">
                                <label for="btn"></label>
                                <button class="btn btn-primary w-100 mt-2" wire:click.prevent="agregarTarifa">Agregar Tarifa</button>
                            </div>
                            <table class="table p-0 table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="thead-light">
                                    <tr>
                                        <th colspan="2">Puerto - Puerto</th>
                                        @if ($tipo_mar_area_terr == 1)
                                        @if($tipo_cont_grup == 1)
                                        <th>20</th>
                                        <th>40</th>
                                        <th>H4</th>
                                        @elseif($tipo_cont_grup == 2)
                                        <th colspan="3">Grupage</th>
                                        @endif
                                        @elseif($tipo_mar_area_terr == 2)
                                        @endif
                                        <th>Validez</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                @foreach ($tarifasSeleccionadas as $index => $tarifa)
                                <tr>
                                    <td colspan="2">{{$this->nombrePuerto($tarifa['origen_id'])}} - {{$this->nombrePuerto($tarifa['destino_id'])}}</td>
                                    @if ($tipo_mar_area_terr == 1)
                                    @if($tipo_cont_grup == 1)
                                    <td>{{$tarifa['precio_contenedor_20']}}</td>
                                    <td>{{$tarifa['precio_contenedor_40']}}</td>
                                    <td>{{$tarifa['precio_contenedor_h4']}}</td>
                                    @elseif($tipo_cont_grup == 2)
                                    <td colspan="3">{{$tarifa['precio_grupage']}}</td>
                                    @endif
                                    @elseif($tipo_mar_area_terr == 2)
                                    @endif
                                    <td>Del {{\Carbon\Carbon::parse($tarifa['efectividad'])->format('d/m') }} Al {{\Carbon\Carbon::parse($tarifa['validez'])->format('d/m')}}</td>
                                    <td><button class="btn btn-danger w-100" wire:click.prevent="eliminarTarifa({{ $index }})">Eliminar</button></td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2">Quebranto Bancario</td>
                                    @if ($tipo_mar_area_terr == 1)
                                        @if($tipo_cont_grup == 1)
                                        <td>1%</td>
                                        <td>1%</td>
                                        <td>1%</td>
                                        @elseif($tipo_cont_grup == 2)
                                        <td colspan="3">1%</td>
                                        @endif
                                        @elseif($tipo_mar_area_terr == 2)
                                        @endif
                                        <td colspan="2">Sobre Divisas</td>
                                </tr>
                                <tr>
                                    <th class="table-active" colspan="2">Gastos</th>
                                    @if($tipo_cont_grup == 1)
                                    <td class="table-active">20'</td>
                                    <td class="table-active">40'</td>
                                    <td class="table-active">H4'</td>
                                    <td colspan="2" class="table-active"></td>
                                    @elseif($tipo_cont_grup == 2)
                                    <td colspan="4">Grupage</td>
                                    @endif
                                </tr>
                                @foreach ($cargo as $index => $cargoExtra)
                                <tr>
                                    <td colspan="2"><input type="text" class="form-control" wire:model="cargo.{{ $index }}.concepto" placeholder="Concepto"></td>
                                    @if($tipo_cont_grup == 1)
                                    <td><input type="number" class="form-control" wire:model="cargo.{{ $index }}.valor20" placeholder="Valor contenedor 20"></td>
                                    <td><input type="number" class="form-control" wire:model="cargo.{{ $index }}.valor40" placeholder="Valor contenedor 40"></td>
                                    <td><input type="number" class="form-control" wire:model="cargo.{{ $index }}.valorHQ" placeholder="valor contenedor HQ"></td>
                                    @elseif($tipo_cont_grup == 2)
                                    <td><input type="number" class="form-control" wire:model="cargo.{{ $index }}.valorHQ" placeholder="valor contenedor HQ"></td>
                                    @endif
                                    <td><input type="text" class="form-control" wire:model="cargo.{{ $index }}.Unidad" placeholder="Unidad"></td>
                                    <td><button class="btn btn-danger" wire:click.prevent="eliminarCargoExtra({{ $index }})">Eliminar</button></td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="7"><button class="btn btn-primary w-100" wire:click.prevent="agregarCargoExtra">Agregar Gastos</button></td>
                                <tr>
                                {{-- <tr>
                                    <th colspan="2">Forfait Gastos Llegada</th>
                                    @if($tipo_cont_grup == 1)
                                    <td><input class="form-control" type="number" wire:model=gastos_llegada_20></td>
                                    <td><input class="form-control" type="number" wire:model=gastos_llegada_40></td>
                                    <td><input class="form-control" type="number" wire:model=gastos_llegada_h4></td>
                                    <td>Por Contenedor</td>
                                    @elseif($tipo_cont_grup == 2)
                                    <td colspan="4"><input class="form-control" type="number" wire:model=gastos_llegada_grupage></td>
                                    @endif
                                </tr> --}}
                                <tr>
                                    <th colspan="2">Transporte Camion</th>
                                        <td colspan="3"><input class="form-control" type="number" wire:model=precio_terrestre></td>
                                        <td>Por Contenedor</td>
                                </tr>
                                <tr>
                                    <th colspan="2">Recargo combustible transporte terrestre</th>
                                    <td>SEGÚN MES</td>
                                    <td>SEGÚN MES</td>
                                    <td>SEGÚN MES</td>
                                    <td>Por Contenedor</td>
                                </tr>
                                <tr>
                                    <th colspan="2">Recargo sobrepeso terrestre (+24 Tn)</th>
                                    <td>30 % s/tte</td>
                                    <td>30 % s/tte</td>
                                    <td>30 % s/tte</td>
                                    <td>Por Contenedor</td>
                                </tr>
                                <tr>
                                    <th class="table-active" colspan="7">Gastos Aduanas</th>
                                </tr>
                                @foreach ($clienteGastos as $aduana)

                                <tr>
                                    <td colspan="2">{{$aduana['titulo']}}</td>
                                    <td colspan="5">{{$aduana['descripcion']}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th class="table-active" colspan="7">Notas</th>
                                </tr>
                                @foreach ($clienteNotas as $notacliente)
                                <tr>
                                    <td colspan="2">{{$notacliente['titulo']}}</td>
                                    <td colspan="5">{{$notacliente['descripcion']}}</td>
                                </tr>
                                @endforeach
                                @foreach ($notas as $index => $nota)
                                <tr>
                                    <td colspan="2"><input type="text" class="form-control" wire:model="notas.{{ $index }}.titulo" placeholder="Concepto"></td>
                                    <td colspan="4"><textarea class="form-control" wire:model="notas.{{ $index }}.descripcion" placeholder="descripción" rows="1"></textarea></td>
                                    <td><button class="btn btn-danger" wire:click.prevent="eliminarNota({{ $index }})">Eliminar</button></td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="7"><button class="btn btn-primary w-100" wire:click.prevent="agregarNota">Agregar Notas</button></td>
                                <tr>
                                <tr>
                                    <th class="table-active" colspan="7">Servicios</th>
                                </tr>
                                @foreach ($servicios as $index => $servicio)
                                <tr>
                                    <td colspan="2"><input type="text" class="form-control" wire:model="servicios.{{ $index }}.titulo" placeholder="Concepto"></td>
                                    <td colspan="4"><textarea class="form-control" wire:model="servicios.{{ $index }}.descripcion" placeholder="descripción" rows="1"></textarea></td>
                                    <td><button class="btn btn-danger" wire:click.prevent="eliminarServicio({{ $index }})">Eliminar</button></td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="7"><button class="btn btn-primary w-100" wire:click.prevent="agregarServicio">Agregar Servicio</button></td>
                                <tr>
                                <tr>
                                    <th class="table-active" colspan="7">Condiciones Generales</th>
                                </tr>
                                @foreach ($generales as $index => $general)
                                <tr>
                                    <td colspan="2"><input type="text" class="form-control" wire:model="generales.{{ $index }}.titulo" placeholder="Concepto"></td>
                                    <td colspan="4"><textarea class="form-control" wire:model="generales.{{ $index }}.descripcion" placeholder="descripción" rows="1"></textarea></td>
                                    <td><button class="btn btn-danger" wire:click.prevent="eliminarGenerales({{ $index }})">Eliminar</button></td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="7"><button class="btn btn-primary w-100" wire:click.prevent="agregarGenerales">Agregar Condiciones</button></td>
                                <tr>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3 justify-content-center">
            <div class="position-fixed">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h5>Opciones de guardado</h5>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="w-100 btn btn-success mb-2" id="alertaGuardar">Actualizar presupuesto</button>
                                <button type="button" class="w-100 btn btn-primary mb-2" wire:click="nuevoPresupuesto">Generear nuevo presupuesto</button>
                                <button type="button" class="w-100 btn btn-danger mb-2" id="alertaEliminar">Eliminar presupuesto</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card m-b-30 mt-3">
                    <div class="card-body">
                        <h5>Acciones</h5>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" wire:click="downloadPdf" class="w-100 btn btn-secondary mb-2">Descargar PDF</button>
                                <button type="button" id="alertaCorreo" class="w-100 btn btn-info mb-2">Enviar Correo</button>
                            </div>
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
            text: 'Pulsa el botón de confirmar para actualizars el presupuesto.',
            icon: 'warning',
            showConfirmButton: true,
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.livewire.emit('update');
            }
        });
    });

    $("#alertaCorreo").on("click", () => {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Pulsa el botón de enviar el presupuesto por correo al cliente.',
            icon: 'warning',
            showConfirmButton: true,
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.livewire.emit('enviarCorreo');
            }
        });
    });

    $("#alertaEliminar").on("click", () => {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Pulsa el botón de confirmar para eliminar los datos del presupuesto. Esto es irreversible.',
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

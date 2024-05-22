<div class="container-fluid">
    <script src="//unpkg.com/alpinejs" defer></script>
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">EDITAR NOTAS/SERVICIOS/CONDICIONES COMUNES</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Presupuestos</a></li>
                    <li class="breadcrumb-item active">Editar Notas/Servicios/Condiciones Comunes</li>
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
                            <table class="table p-0 table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <th class="table-active" colspan="7">Notas</th>
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
                                <button type="button" class="w-100 btn btn-success mb-2" id="alertaGuardar">Actualizar </button>
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
            text: 'Pulsa el botón de confirmar para actualizar.',
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
@endsection

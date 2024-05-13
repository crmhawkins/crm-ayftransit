<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">CREAR DE TARIFAS</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Tarifas</a></li>
                    <li class="breadcrumb-item active">Crear Tarifas</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->

    <div class="row">
        <div class="col-md-9">
            <div class="card m-b-30">
                <div class="card-body">
                    <form wire:submit.prevent="submit" >
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label>Tipo de Tarifa:</label>
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
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="nombre" class="col-form-label">Naviera</label>
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
                            <div class="col-sm-2">
                                <label for="cargo40" class="col-form-label">Cargo a sumar 20</label>
                                <input type="number" wire:model="cargo20" class="form-control" id="cargo20" placeholder="Precio">
                            </div>
                            <div class="col-sm-2">
                                <label for="nombre" class="col-form-label">Cargo a sumar 40</label>
                                <input type="number" wire:model="cargo40" class="form-control" id="cargo40" placeholder="Precio">
                            </div>
                            <div class="col-sm-2">
                                <label for="cargoHc" class="col-form-label">Cargo a sumar HC</label>
                                <input type="number" wire:model="cargoHc" class="form-control" id="cargoHc" placeholder="Precio">
                            </div>
                            <div class="col-sm-2">
                                <label for="cargoGrup" class="col-form-label">Cargo a sumar Grupage</label>
                                <input type="number" wire:model="cargoGrup" class="form-control" id="cargoGrup" placeholder="Precio">
                            </div>
                        </div>
                        <div id="spreadsheet" style="width: 100%; overflow-x: auto; height: auto;" wire:ignore></div>
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
                            <button class="w-100 btn btn-success mb-2" id="alertaGuardar">Subir Tarifas</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jexcel/4.6.1/jexcel.js" integrity="sha512-eo3imribEfgBrcEBfkuPPvptp5ZyopNENkub6vM1AQgsXxuRPey4vqr3Zh9INT8cDKLQ4xmiwDtuSC5yS2xfTg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jexcel/4.6.1/jexcel.css" integrity="sha512-0bbZhbex+69JOTnHNCYlUFQY3Td5bVRJAnAnJx7wiqbt1aWAvjcifiARBG7devNOkunj2TtkWc7CzB1QLTffsQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/jsuites/5.4.0/jsuites.js" integrity="sha512-U3D8JZ73NCnnDqsf5zYMHnRAm0yqBdqjrlqI/HwTOq8NSJeLP2f8szMy2LXG7gkBAkgG2i9sNiocRRjUA6izMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsuites/5.4.0/jsuites.css" integrity="sha512-y8XfNoBg3vVrJ9K/4mDYA8gJ3ZsFYX3n9zr9NqYtponQfzsSc56qF4gm4VWLkL37rko2k7fyA9A0e39fAq+dIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script>
    $(document).ready(function() {
        var data = [];
        var spreadsheetContainer = document.getElementById('spreadsheet');
        var containerWidth = spreadsheetContainer.offsetWidth;

        var widthInPercent = (percentage) => Math.round(containerWidth * (percentage / 100));

        var mySpreadsheet = jexcel(document.getElementById('spreadsheet'), {
            data: data,
            minDimensions: [7, 20],
            columns: [
                {type: 'calendar', title: 'Fecha validez', width: widthInPercent(15), options: { format: 'YYYY-MM-DD' }},
                {type: 'calendar', title: 'Fecha efectividad', width: widthInPercent(15), options: { format: 'YYYY-MM-DD' }},
                {type: 'text', title: 'Origen', width: widthInPercent(10)},
                {type: 'text', title: 'Destino', width: widthInPercent(10)},
                {type: 'number', title: 'Precio 20', width: widthInPercent(10)},
                {type: 'number', title: 'Precio 40', width: widthInPercent(10)},
                {type: 'number', title: 'Precio HC', width: widthInPercent(10)},
                {type: 'number', title: 'Precio Grupage', width: widthInPercent(10)},
            ]
        });
        $("#alertaGuardar").on("click", () => {
        var data = mySpreadsheet.getData();
            console.log(data); // Verificar qué se captura antes de enviar
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Pulsa el botón de confirmar para guardar el Proveedor.',
                icon: 'warning',
                showConfirmButton: true,
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('guardarTarifas', data);
                }
            });
        });
    });
</script>
@endsection



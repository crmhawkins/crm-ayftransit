<div class="container-fluid">
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.apple-mapkit.com/mk/5.x.x/mapkit.js" defer></script>
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">CREAR PRESUPUESTO</span></h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Presupuestos</a></li>
                    <li class="breadcrumb-item active">Crear Presupuesto</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->

    <div class="row">
        <div class="col-md-9">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="form-row mb-4 justify-content-center">
                        <div class="form-group col-md-12">
                            <h5 class="ms-3" style="border-bottom: 1px gray solid !important; padding-bottom: 10px !important;">Datos básicos del presupuesto</h5>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fechaEmision">Fecha de emisión</label>
                            <input type="date" wire:model.defer="fechaEmision" class="form-control"
                                name="fechaEmision" id="fechaEmision" placeholder="X">
                        </div>
                        <div class="form-group col-md-6" wire:ignore>
                            <label for="fechaVencimiento">Estado</label>
                            <select class="form-control" name="estado" id="estado" wire:model="estado">
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Cancelado">Cancelado</option>
                                    <option value="Aceptado">Aceptado</option>
                                    <option value="Completado">Completado</option>
                                    <option value="Facturado">Facturado</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <h5 class="ms-3"
                                style="border-bottom: 1px gray solid !important; padding-bottom: 10px !important;">
                                Datos
                                del cliente</h5>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="input-group mb-1">
                                <br>
                                <span class="col-md-2">Selecciona un cliente</span>
                                <div class="col-md-4">
                                    <select class="form-control" name="id_cliente" id="id_cliente"
                                        wire:model="id_cliente">
                                        <option value="0">-- ELIGE UN CLIENTE --</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">
                                                {{ $cliente->empresa }}-{{ $cliente->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="col-md-2">Selecciona un proveedor</span>
                                <div class="col-md-4">
                                    <select class="form-control" name="id_proveedor" id="id_proveedor"
                                        wire:model="id_proveedor">
                                        <option value="0">-- ELIGE UN PROVEEDOR --</option>
                                        @foreach ($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}">
                                                {{ $proveedor->nombre }}-{{ $proveedor->contacto }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="form-row mt-3">
                        <div class="form-group col-md-12">
                            <h5 class="ms-3"
                                style="border-bottom: 1px gray solid !important; padding-bottom: 10px !important;">
                                Datos
                                del cliente</h5>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="input-group mb-1">
                                <br>
                                <span class="col-md-2">Selecciona un cliente existente</span>
                                <div class="col-md-8">
                                    <select class="form-control" name="id_cliente" id="id_cliente"
                                        wire:model="id_cliente">
                                        <option value="0">-- ELIGE UN CLIENTE --</option>
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">
                                                {{ $cliente->empresa }}-{{ $cliente->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 justify-content-center">
        <div class="card m-b-30 position-fixed">
            <div class="card-body">
                <h5>Opciones de guardado</h5>
                <div class="row">
                    <div class="col-12">
                        <button class="w-100 btn btn-success mb-2" wire:click.prevent="alertaGuardar">Guardar
                            presupuesto</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        fieldset.scheduler-border {
            border: 1px groove #ddd !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        table {
            border: 1px black solid !important;
        }

        th {
            border-bottom: 1px black solid !important;
            border: 1px black solid !important;
            border-top: 1px black solid !important;
        }

        th.header {
            border-bottom: 1px black solid !important;
            border: 1px black solid !important;
            border-top: 2px black solid !important;
        }

        td.izquierda {
            border-left: 1px black solid !important;

        }

        td.derecha {
            border-right: 1px black solid !important;

        }

        td.suelo {}
    </style>
    <script>
        window.addEventListener('initializeMapKit', () => {
            fetch('/admin/service/jwt')
                .then(response => response.json())
                .then(data => {
                    mapkit.init({
                        authorizationCallback: function(done) {
                            done(data.token);
                        }
                    });
                    // Aquí puedes inicializar tu mapa u otras funcionalidades relacionadas
                });
        });
    </script>
</div>
</div>
@section('scripts')
    {{-- <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    {{-- <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script> --}}
    <script>
        // In your Javascript (external .js resource or <script> tag)

        $("#alertaGuardar").on("click", () => {
            Swal.fire({
                title: '¿Estás seguro?',
                icon: 'warning',
                showConfirmButton: true,
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.livewire.emit('submitEvento');
                }
            });
        });

        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '< Ant',
            nextText: 'Sig >',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                'Octubre', 'Noviembre', 'Diciembre'
            ],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
            weekHeader: 'Sm',
            dateFormat: 'yy-mm-dd',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);

        document.addEventListener("livewire:load", () => {
            Livewire.hook('message.processed', (message, component) => {
                $('.js-example-basic-single').select2();
            });

        });



        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var eyeIcon = document.getElementById("eye-icon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.className = "fas fa-eye-slash";
            } else {
                passwordInput.type = "password";
                eyeIcon.className = "fas fa-eye";
            }
        }




        document.addEventListener('DOMSubtreeModified', (e) => {
            $("#diaEvento").datepicker();


            $("#diaFinal").datepicker();

            $("#diaFinal").on('change', function(e) {
                @this.set('diaFinal', $('#diaFinal').val());

            });

            $("#diaEvento").on('change', function(e) {
                @this.set('diaEvento', $('#diaEvento').val());
                @this.set('diaFinal', $('#diaEvento').val());

            });

            $('#id_cliente').on('change', function(e) {
                console.log('change')
                console.log(e.target.value)
                var data = $('#id_cliente').select2("val");
                @this.set('id_cliente', data);
                Livewire.emit('selectCliente')

            })
        })

        function OpenSecondPage() {
            var id = @this.id_cliente
            window.open(`/admin/clientes-edit/` + id, '_blank'); // default page
        };
    </script>
@endsection

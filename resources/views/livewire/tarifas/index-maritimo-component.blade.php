<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">TARIFAS</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Tarifas</a></li>
                    <li class="breadcrumb-item active">Todos las Tarifas maritimas</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">

                    <h4 class="mt-0 header-title">Listado de todas las tarifas maritimas</h4>
                    <p class="sub-title">Listado completo de todas las tarifas maritimas, para editar o ver la información completa pulse el botón de Editar en la columna acciones.</p>

                    @if (count($tarifas) > 0)
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">Proveedor</th>
                                    <th scope="col">Origen</th>
                                    <th scope="col">Destino</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Tiempo estimado</th>
                                    <th scope="col">Validez</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tarifas as $tarifa)
                                    <tr>
                                        <td>{{ $this->getProveedor($tarifa->proveedor_id) }}</td>
                                        <td>{{ $this->getPuerto($tarifa->origen_id) }}</td>
                                        <td>{{ $this->getPuerto($tarifa->destino_id) }}</td>
                                        <td>{{ $this->tipo($tarifa->tipo_imp_exp) }}</td>
                                        <td>{{ $tarifa->dias }}</td>
                                        <td>{{ $tarifa->validez }}</td>
                                        <td>
                                            <a href="{{ route('tarifas.edit', $tarifa->id) }}" class="btn btn-primary">Ver/Editar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No hay tarifas maritmas registrados aún.</p>
                    @endif

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>


    @section('scripts')

    <!-- Required datatable js -->
    <script src="../assets/js/jquery.slimscroll.js"></script>

    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Buttons examples -->
    <script src="../plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="../plugins/datatables/buttons.bootstrap4.min.js"></script>
    <script src="../plugins/datatables/jszip.min.js"></script>
    <script src="../plugins/datatables/pdfmake.min.js"></script>
    <script src="../plugins/datatables/vfs_fonts.js"></script>
    <script src="../plugins/datatables/buttons.html5.min.js"></script>
    <script src="../plugins/datatables/buttons.print.min.js"></script>
    <script src="../plugins/datatables/buttons.colVis.min.js"></script>
    <!-- Responsive examples -->
    <script src="../plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="../plugins/datatables/responsive.bootstrap4.min.js"></script>
    <script src="../assets/pages/datatables.init.js"></script>

    @endsection


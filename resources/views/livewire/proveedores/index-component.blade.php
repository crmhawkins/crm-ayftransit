<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">Proveedores</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Proveedores</a></li>
                    <li class="breadcrumb-item active">Todos los proveedores</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">

                    <h4 class="mt-0 header-title">Listado de todos los proveedores</h4>
                    <p class="sub-title">Listado completo de todos nuestros proveedores, para editar o ver la información completa pulse el botón de Editar en la columna acciones.</p>

                    @if (count($Proveedores) > 0)
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Dirección</th>
                                    <th scope="col">Teléfono</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Proveedores as $Proveedor)
                                    <tr>
                                        <td>{{ $Proveedor->nombre }}</td>
                                        <td>{{ $Proveedor->direccion }}</td>
                                        <td>{{ $Proveedor->telefono }}</td>
                                        <td>{{ $Proveedor->email }}</td>
                                        <td> 
                                            <a href="{{ route('proveedores.edit', $Proveedor->id) }}" class="btn btn-primary">Ver/Editar</a> 
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No hay Proveedores registrados aún.</p>
                    @endif

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->    
</div>
    

    @section('scripts')

    <!-- Required datatable js -->
    {{-- <script src="../assets/js/jquery.min.js"></script> --}}
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

    {{-- 

        <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script> --}}
        {{-- <script>
            $(document).ready(function() {
                console.log('entro');
                $('#datatable-buttons').DataTable({
                    responsive: true,
                    dom: 'Bfrtip',
                    // buttons: [
                    //     'csv', 'excel', 'pdf', 'print'
                    //     // 'copy', 'csv', 'excel', 'pdf', 'print'
                    // ],
                    buttons: [{
                        extend: 'collection',
                        text: 'Export',
                        buttons: [{
                                extend: 'pdf',
                                className: 'btn btn-secondary buttons-copy buttons-html5'
                            },
                            {
                                extend: 'excel',
                                className: 'btn btn-secondary buttons-copy buttons-html5'
                            }
                        ],
                        className: 'btn-group'
                    }],
                    "language": {
                        "lengthMenu": "Mostrando _MENU_ registros por página",
                        "zeroRecords": "Nothing found - sorry",
                        "info": "Mostrando página _PAGE_ of _PAGES_",
                        "infoEmpty": "No hay registros disponibles",
                        "infoFiltered": "(filtrado de _MAX_ total registros)",
                        "search": "Buscar:",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        },
                        "zeroRecords": "No se encontraron registros coincidentes",
                    }
                });

                addEventListener("resize", (event) => {
                    location.reload();
                })
            });
        </script> --}}
    @endsection

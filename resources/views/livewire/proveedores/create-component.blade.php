<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h4 class="page-title">CREAR PROVEEDOR</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Proveedores</a></li>
                    <li class="breadcrumb-item active">Crear Proveedor</li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div>
    <!-- end page-title -->

    <div class="row">
        <div class="col-md-12">
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
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success">Guardar Proveedor</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
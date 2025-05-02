@extends("layouts.app") {{-- Asegúrate de que este layout exista y sea el correcto --}}

@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __("Importar Tarifas desde Excel") }}</div>

                <div class="card-body">
                    @if (session("success"))
                        <div class="alert alert-success" role="alert">
                            {{ session("success") }}
                        </div>
                    @endif
                    @if (session("error"))
                        <div class="alert alert-danger" role="alert">
                            {{ session("error") }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route("tarifas.import.handle") }}" enctype="multipart/form-data">
                        @csrf

                        {{-- Campos Adicionales --}}
                        <div class="row mb-3">
                            <label for="tipo_mar_area_terr" class="col-md-4 col-form-label text-md-end">{{ __("Tipo Tarifa") }}</label>
                            <div class="col-md-6">
                                <select id="tipo_mar_area_terr" class="form-select @error("tipo_mar_area_terr") is-invalid @enderror" name="tipo_mar_area_terr" required>
                                    <option value="" disabled selected>Selecciona el tipo</option>
                                    <option value="1" {{ old("tipo_mar_area_terr") == 1 ? "selected" : "" }}>Marítima</option>
                                    <option value="2" {{ old("tipo_mar_area_terr") == 2 ? "selected" : "" }}>Aérea</option>
                                    <option value="3" {{ old("tipo_mar_area_terr") == 3 ? "selected" : "" }}>Terrestre</option>
                                </select>
                                @error("tipo_mar_area_terr") <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tipo_imp_exp" class="col-md-4 col-form-label text-md-end">{{ __("Importación/Exportación") }}</label>
                            <div class="col-md-6">
                                <select id="tipo_imp_exp" class="form-select @error("tipo_imp_exp") is-invalid @enderror" name="tipo_imp_exp" required>
                                    <option value="" disabled selected>Selecciona el tipo</option>
                                    <option value="IMP" {{ old("tipo_imp_exp") == "IMP" ? "selected" : "" }}>Importación</option>
                                    <option value="EXP" {{ old("tipo_imp_exp") == "EXP" ? "selected" : "" }}>Exportación</option>
                                </select>
                                @error("tipo_imp_exp") <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tipo_cont_grup" class="col-md-4 col-form-label text-md-end">{{ __("Contenedor/Grupaje") }}</label>
                            <div class="col-md-6">
                                <select id="tipo_cont_grup" class="form-select @error("tipo_cont_grup") is-invalid @enderror" name="tipo_cont_grup" required>
                                    <option value="" disabled selected>Selecciona el tipo</option>
                                    <option value="Contenedor" {{ old("tipo_cont_grup") == "Contenedor" ? "selected" : "" }}>Contenedor</option>
                                    <option value="Grupaje" {{ old("tipo_cont_grup") == "Grupaje" ? "selected" : "" }}>Grupaje</option>
                                </select>
                                @error("tipo_cont_grup") <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>
                        </div>
                        {{-- Fin Campos Adicionales --}}

                        {{-- Campos Suma --}}
                        <hr>
                        <p class="text-center"><strong>Cantidades a sumar (opcional):</strong></p>
                        <div class="row mb-3">
                            <label for="cargo20" class="col-md-4 col-form-label text-md-end">{{ __("Suma a 20'") }}</label>
                            <div class="col-md-6">
                                <input id="cargo20" type="number" step="0.01" class="form-control @error("cargo20") is-invalid @enderror" name="cargo20" value="{{ old("cargo20", 0) }}">
                                @error("cargo20") <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="cargo40" class="col-md-4 col-form-label text-md-end">{{ __("Suma a 40'") }}</label>
                            <div class="col-md-6">
                                <input id="cargo40" type="number" step="0.01" class="form-control @error("cargo40") is-invalid @enderror" name="cargo40" value="{{ old("cargo40", 0) }}">
                                @error("cargo40") <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="cargoHc" class="col-md-4 col-form-label text-md-end">{{ __("Suma a 40'HC") }}</label>
                            <div class="col-md-6">
                                <input id="cargoHc" type="number" step="0.01" class="form-control @error("cargoHc") is-invalid @enderror" name="cargoHc" value="{{ old("cargoHc", 0) }}">
                                @error("cargoHc") <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="cargoGrup" class="col-md-4 col-form-label text-md-end">{{ __("Suma a Grupage") }}</label>
                            <div class="col-md-6">
                                <input id="cargoGrup" type="number" step="0.01" class="form-control @error("cargoGrup") is-invalid @enderror" name="cargoGrup" value="{{ old("cargoGrup", 0) }}">
                                @error("cargoGrup") <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>
                        </div>
                        {{-- Fin Campos Suma --}}

                        <hr>

                        <div class="row mb-3">
                            <label for="proveedor" class="col-md-4 col-form-label text-md-end">{{ __("Proveedor/Formato Excel") }}</label>
                            <div class="col-md-6">
                                <select id="proveedor" class="form-select @error("proveedor") is-invalid @enderror" name="proveedor" required>
                                    <option value="" disabled selected>Selecciona un proveedor/formato</option>
                                    @foreach($proveedores as $key => $value)
                                        <option value="{{ $key }}" {{ old("proveedor") == $key ? "selected" : "" }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error("proveedor") <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tarifa_excel" class="col-md-4 col-form-label text-md-end">{{ __("Archivo Excel (.xlsx, .xls)") }}</label>
                            <div class="col-md-6">
                                <input id="tarifa_excel" type="file" class="form-control @error("tarifa_excel") is-invalid @enderror" name="tarifa_excel" required accept=".xlsx,.xls">
                                @error("tarifa_excel") <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __("Importar Tarifas") }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Presupuesto Detalle</title>
    <link href="https://fonts.googleapis.com/css?family=Arial:400,700" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10pt;
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            text-align: center;
            padding: 10px 20px;
            border-bottom: 2px solid #000;
        }

        header img {
            width: 100%;
            display: block;
            margin: 0 auto;
        }

        header h1 {
            font-size: 14pt;
            margin: 10px 0 0 0;
        }

        footer {
            text-align: center;
            padding: 10px 20px;
            border-top: 2px solid #000;
            font-size: 8pt;
        }

        .section-title {
            font-size: 12pt;
            font-weight: bold;
            padding: 5px 0;
            border-bottom: 2px solid #000;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .special-th {
            background-color: #e0e0e0;
            font-size: 10pt;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .notes, .services, .general-conditions {
            margin-top: 20px;
        }

        .notes th, .services th, .general-conditions th {
            background-color: #f0f0f0;
        }

        .notes td, .services td, .general-conditions td {
            background-color: #fff;
        }

        .notes th, .services th, .general-conditions th, .notes td, .services td, .general-conditions td {
            border: none;
            padding: 4px;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ public_path('images/logo_afy.jpg') }}" alt="Logo">
        <h1>Presupuesto Nº {{ $identificador }}</h1>
        <div>Fecha de Emisión: {{ $presupuesto->fechaEmision }}</div>
    </header>

    <section>
        <div class="section-title">Datos Cliente</div>
        <p><strong>Empresa:</strong> {{ $clientes->find($presupuesto->id_cliente)->empresa }}</p>
        <p><strong>Contacto:</strong> {{ $clientes->find($presupuesto->id_cliente)->nombre }}</p>
    </section>

    <section>
        <div class="section-title">Detalle de Flete Marítimo y Gastos</div>
        <table>
            <thead>
                <tr>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Validez</th>
                    @if ($presupuesto->tipo_mar_area_terr == 1)
                        @if($presupuesto->tipo_cont_grup == 1)
                            <th>Precio 20'</th>
                            <th>Precio 40'</th>
                            <th>Precio HQ'</th>
                        @elseif($presupuesto->tipo_cont_grup == 2)
                            <th>Grupage</th>
                        @endif
                    @elseif($presupuesto->tipo_mar_area_terr == 2)
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($tarifasSeleccionadas as $tarifa)
                <tr>
                    <td>{{ $puertos->find($tarifa['origen_id'])->Nombre }}</td>
                    <td>{{ $puertos->find($tarifa['destino_id'])->Nombre }}</td>
                    <td>{{ $tarifa['validez'] }}</td>
                    @if ($presupuesto->tipo_mar_area_terr == 1)
                        @if($presupuesto->tipo_cont_grup == 1)
                            <td>{{ number_format($tarifa['precio_contenedor_20'], 2, ',', '.') }} €</td>
                            <td>{{ number_format($tarifa['precio_contenedor_40'], 2, ',', '.') }} €</td>
                            <td>{{ number_format($tarifa['precio_contenedor_h4'], 2, ',', '.') }} €</td>
                        @elseif($presupuesto->tipo_cont_grup == 2)
                            <td>{{ number_format($tarifa['precio_grupage'], 2, ',', '.') }} €</td>
                        @endif
                    @elseif($presupuesto->tipo_mar_area_terr == 2)
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th>Gastos</th>
                    @if($presupuesto->tipo_cont_grup == 1)
                        <th>20'</th>
                        <th>40'</th>
                        <th>HQ'</th>
                        <th></th>
                    @elseif($presupuesto->tipo_cont_grup == 2)
                        <th colspan="4">Grupage</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Forfait Gastos Llegada</th>
                    @if($presupuesto->tipo_cont_grup == 1)
                    <td>{{$presupuesto->gastos_llegada_20}}</td>
                    <td>{{$presupuesto->gastos_llegada_40}}</td>
                    <td>{{$presupuesto->gastos_llegada_h4}}</td>
                    <td>Por Contenedor</td>
                    @elseif($presupuesto->tipo_cont_grup == 2)
                    <td colspan="4">{{$presupuesto->gastos_llegada_grupage}}</td>
                    @endif
                </tr>
                <tr>
                    <th>Transporte Camion</th>
                    <td colspan="3">{{$presupuesto->precio_terrestre}}</td>
                    <td>Por Contenedor</td>
                </tr>
                <tr>
                    <th>Recargo combustible transporte terrestre</th>
                    <td>SEGÚN MES</td>
                    <td>SEGÚN MES</td>
                    <td>SEGÚN MES</td>
                    <td>Por Contenedor</td>
                </tr>
                <tr>
                    <th>Recargo sobrepeso terrestre (+24 Tn)</th>
                    <td>30 % s/tte</td>
                    <td>30 % s/tte</td>
                    <td>30 % s/tte</td>
                    <td>Por Contenedor</td>
                </tr>
                @foreach ($cargo as $cargoExtra)
                <tr>
                    <td>{{$cargoExtra['concepto']}}</td>
                    <td>{{$cargoExtra['valor20']}}</td>
                    <td>{{$cargoExtra['valor40']}}</td>
                    <td>{{$cargoExtra['valorHQ']}}</td>
                    <td>{{$cargoExtra['Unidad']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <section class="notes">
        <table>
            <thead>
                <tr>
                    <th colspan="4">Notas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notas as $nota)
                <tr>
                    <td>{{$nota['titulo']}}</td>
                    <td colspan="3">{{$nota['descripcion']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <section class="services">
        <table>
            <thead>
                <tr>
                    <th colspan="4">Servicios</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($servicios as $servicio)
                <tr>
                    <td>{{$servicio['titulo']}}</td>
                    <td colspan="3">{{$servicio['descripcion']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <section class="general-conditions">
        <table>
            <thead>
                <tr>
                    <th colspan="4">Condiciones Generales</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($generales as $general)
                <tr>
                    <td>{{$general['titulo']}}</td>
                    <td colspan="3">{{$general['descripcion']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <footer>
        <p>Gracias por seguir confiando y valorando nuestros servicios.</p>
        <p><strong>Dirección:</strong> Edificio Arttysur Parque Empresarial Palmones - Avda. de los Empresarios nº 20 Planta 4 Oficina 14, 11379 Palmones, Los Barrios (Cádiz) España</p>
        <p><strong>Tel:</strong> +34 956 631 940 | <strong>Email:</strong> comercial@ayftransit.com</p>
    </footer>
</body>
</html>

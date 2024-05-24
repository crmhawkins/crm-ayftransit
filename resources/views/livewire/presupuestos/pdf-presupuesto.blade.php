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

            color: #333;
        }

        header {
            text-align: center;
            padding: 10px 20px;
            border-bottom: 2px solid #30419b;
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


        .section-title {
            font-size: 12pt;
            font-weight: bold;
            padding: 5px 0;
            border-bottom: 2px solid #30419b;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead th {
            border-bottom: 2px solid #30419b;

        }
        th {

            padding: 5px;
            text-align: left;
        }
        .linea {
            border-right: 2px solid #30419b;
        }
        td {
            padding: 5px;
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
        .datos-cliente{
            display: inline-block;
            width: 49%;
        }
        .derecha{
            text-align: right;
            transform: translateY(-10px) !important;
        }
        span.derecha{
            padding: 4%;
            background-color: #30419b;
            color:#fff;
        }
        span.izquierda{
            margin:10px 0 10px;
            display: block;
        }
        .cliente{
            margin: 10px 0 0 0 ;
            width: 100%;
        }
        .footer{
            background-color: #30419b;
            color:#fff;
            padding: 10px;
        }
        footer {
            font-size: 8pt;
            bottom: 0;
            position: fixed;
            width: 100%;
        }
        .firma{
            display: block;
            width: 100%;
        }
        .firma-footer{
            display: inline-block;
            width: 49.5%;
        }
        span.foot{
            margin:10px 0 10px;
            display: block;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ public_path('images/logo_afy.jpg') }}" alt="Logo">
    </header>

    <section>
        <div class="section-title">Datos Cliente</div>
        <div class="cliente">
            <div class= "datos-cliente">
                <span class="izquierda"><strong>Empresa:</strong> {{ $clientes->find($presupuesto->id_cliente)->empresa }}</span>
                <span class="izquierda"><strong>Contacto:</strong> {{ $clientes->find($presupuesto->id_cliente)->nombre }}</span>
            </div>
            <div class= "datos-cliente derecha">
                <span class="derecha"><strong>Presupuesto Nº:</strong> {{ $identificador }}</span>
                <span class="derecha"><strong>Fecha de Emisión:</strong> {{ $presupuesto->fechaEmision }}</span>
            </div>


        </div>
    </section>

    <section>
        <div class="section-title">Detalle de Flete Marítimo y Gastos</div>
        <table class="table-sm">
            <thead>
                <tr>
                    <th>Origen</th>
                    <th>Destino</th>
                    @if ($presupuesto->tipo_mar_area_terr == 1)
                    @if($presupuesto->tipo_cont_grup == 1)
                    <th class="text-center">Precio 20'</th>
                    <th class="text-center">Precio 40'</th>
                    <th class="text-center">Precio HQ'</th>
                    @elseif($presupuesto->tipo_cont_grup == 2)
                    <th>Grupage</th>
                    @endif
                    @elseif($presupuesto->tipo_mar_area_terr == 2)
                    @endif
                    <th>Validez</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tarifasSeleccionadas as $tarifa)
                <tr>
                    <td>{{ $puertos->find($tarifa['origen_id'])->Nombre }}</td>
                    <td class="linea">{{ $puertos->find($tarifa['destino_id'])->Nombre }}</td>
                    @if ($presupuesto->tipo_mar_area_terr == 1)
                    @if($presupuesto->tipo_cont_grup == 1)
                    <td class="text-center">{{ number_format($tarifa['precio_contenedor_20'], 2, ',', '.') }} €</td>
                    <td class="text-center">{{ number_format($tarifa['precio_contenedor_40'], 2, ',', '.') }} €</td>
                    <td class="text-center">{{ number_format($tarifa['precio_contenedor_h4'], 2, ',', '.') }} €</td>
                    @elseif($presupuesto->tipo_cont_grup == 2)
                    <td class="text-center">{{ number_format($tarifa['precio_grupage'], 2, ',', '.') }} €</td>
                    @endif
                    @elseif($presupuesto->tipo_mar_area_terr == 2)
                    @endif
                    <td>Del {{\Carbon\Carbon::parse($tarifa['efectividad'])->format('d/m') }} Al {{\Carbon\Carbon::parse($tarifa['validez'])->format('d/m')}}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="2">Quebranto Bancario</td>
                    @if ($presupuesto->tipo_mar_area_terr == 1)
                        @if($presupuesto->tipo_cont_grup == 1)
                        <td>1%</td>
                        <td>1%</td>
                        <td>1%</td>
                        @elseif($presupuesto->tipo_cont_grup == 2)
                        <td colspan="3">1%</td>
                        @endif
                        @elseif($presupuesto->tipo_mar_area_terr == 2)
                        @endif
                        <td colspan="2">Sobre Divisas</td>
                </tr>
            </tbody>
            <thead>
                <tr>
                    <th colspan="2">Gastos</th>
                    @if($presupuesto->tipo_cont_grup == 1)
                        <th class="text-center">20'</th>
                        <th class="text-center">40'</th>
                        <th class="text-center">HQ'</th>
                        <th></th>
                    @elseif($presupuesto->tipo_cont_grup == 2)
                        <th class="text-center" colspan="4">Grupage</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($cargo as $cargoExtra)
                <tr>
                    <th class="linea" colspan="2">{{$cargoExtra['concepto']}}</th>
                    <td class="text-center">{{$cargoExtra['valor20']}}</td>
                    <td class="text-center">{{$cargoExtra['valor40']}}</td>
                    <td class="text-center">{{$cargoExtra['valorHQ']}}</td>
                    <td>{{$cargoExtra['Unidad']}}</td>
                </tr>
                @endforeach
                <tr>
                    <th colspan="2"  class="linea">Forfait Gastos Llegada</th>
                    @if($presupuesto->tipo_cont_grup == 1)
                    <td class="text-center">{{$presupuesto->gastos_llegada_20}}</td>
                    <td class="text-center">{{$presupuesto->gastos_llegada_40}}</td>
                    <td class="text-center">{{$presupuesto->gastos_llegada_h4}}</td>
                    <td>Por Contenedor</td>
                    @elseif($presupuesto->tipo_cont_grup == 2)
                    <td class="text-center" colspan="4">{{$presupuesto->gastos_llegada_grupage}}</td>
                    @endif
                </tr>
                <tr>
                    <th class="linea" colspan="2">Transporte Camion</th>
                    <td class="text-center" colspan="3">{{$presupuesto->precio_terrestre}}</td>
                    <td>Por Contenedor</td>
                </tr>
                <tr>
                    <th class="linea" colspan="2">Recargo combustible transporte terrestre</th>
                    <td class="text-center">SEGÚN MES</td>
                    <td class="text-center">SEGÚN MES</td>
                    <td class="text-center">SEGÚN MES</td>
                    <td>Por Contenedor</td>
                </tr>
                <tr>
                    <th class="linea" colspan="2">Recargo sobrepeso terrestre (+24 Tn)</th>
                    <td class="text-center">30 % s/tte</td>
                    <td class="text-center">30 % s/tte</td>
                    <td class="text-center">30 % s/tte</td>
                    <td>Por Contenedor</td>
                </tr>
            </tbody>
            <thead>
                <tr>
                    <th colspan="6">Gastos Aduanas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clienteGastos as $aduana)
                <tr>
                    <td class="linea" colspan="2">{{$aduana['titulo']}}</td>
                    <td colspan="4">{{$aduana['descripcion']}}</td>
                </tr>
                @endforeach
            </tbody>
            <thead>
                <tr>
                    <th colspan="6">Notas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clienteNotas as $notacliente)
                    <tr>
                        <td class="linea" colspan="2">{{$notacliente['titulo']}}</td>
                        <td colspan="4">{{$notacliente['descripcion']}}</td>
                    </tr>
                @endforeach
                @foreach ($notas as $nota)
                <tr>
                    <td class="linea" colspan="2">{{$nota['titulo']}}</td>
                    <td colspan="4">{{$nota['descripcion']}}</td>
                </tr>
                @endforeach
            </tbody>
            <thead>
                <tr>
                    <th colspan="6">Servicios</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($servicios as $servicio)
                <tr>
                    <td class="linea" colspan="2">{{$servicio['titulo']}}</td>
                    <td colspan="4">{{$servicio['descripcion']}}</td>
                </tr>
                @endforeach
            </tbody>

            <thead>
                <tr>
                    <th colspan="6">Condiciones Generales</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($generales as $general)
                <tr>
                    <td class="linea" colspan="2">{{$general['titulo']}}</td>
                    <td colspan="4">{{$general['descripcion']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
    <footer>
        <div class="firma">
            <div class="firma-footer footer-izquierda" style="transform: translateY(-20px) !important;">
                <p>Gracias por seguir confiando y valorando nuestros servicios.</p>
            </div>
            <div class="firma-footer footer-derecha" style="text-align:right!important;">
                <span class="foot">Atentamente,</span>
                <span class="foot">Dpto. Tráfico Comercial</div>
            </div>
        </div>

        <div class="footer text-center">
            <p>Area de Servicio El Fresno, Torre A, oficina 404, 11370 Los Barrios, Cádiz</p>
        <p>Tel + 34 956 631 940 - Extensión 2 Fax + 34 956 631 800 E-mail: comercial@ayftransit.com</p>
        </div>
    </footer>
</body>
</html>

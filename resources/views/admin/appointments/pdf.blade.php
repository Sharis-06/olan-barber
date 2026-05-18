<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Cita - Olan BarberShop</title>
    <style>
        @page {
            margin: 0px;
        }
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            background-color: #ffffff;
            color: #333333;
            margin: 0;
            padding: 40px;
            font-size: 14px;
            line-height: 1.5;
        }
        .ticket-container {
            max-width: 480px;
            margin: 0 auto;
            border: 2px solid #c5a880;
            border-radius: 12px;
            padding: 30px;
            background-color: #fafafa;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            position: relative;
        }
        /* Top barber pole design */
        .barber-pole {
            height: 6px;
            background: repeating-linear-gradient(
                -45deg,
                #1e3a8a,
                #1e3a8a 10px,
                #ffffff 10px,
                #ffffff 20px,
                #b91c1c 20px,
                #b91c1c 30px,
                #ffffff 30px,
                #ffffff 40px
            );
            border-radius: 4px 4px 0 0;
            margin-bottom: 25px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
        }
        .logo-title {
            font-size: 26px;
            font-weight: bold;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
        }
        .logo-subtitle {
            font-size: 12px;
            color: #c5a880;
            text-transform: uppercase;
            letter-spacing: 4px;
            margin: 5px 0 0 0;
            font-weight: 600;
        }
        .divider-gold {
            height: 2px;
            background-color: #c5a880;
            width: 80%;
            margin: 15px auto;
        }
        .ticket-info {
            text-align: center;
            font-size: 11px;
            color: #666666;
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .info-table td {
            padding: 10px 0;
            border-bottom: 1px dashed #dddddd;
        }
        .info-table td.label {
            font-weight: bold;
            color: #555555;
            width: 35%;
            text-transform: uppercase;
            font-size: 12px;
        }
        .info-table td.value {
            color: #1a1a1a;
            text-align: right;
            font-size: 13px;
        }
        .info-table td.price {
            font-size: 18px;
            font-weight: bold;
            color: #a2835b;
            text-align: right;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: right;
        }
        .status-pendiente { background-color: #fef3c7; color: #d97706; }
        .status-confirmada { background-color: #d1fae5; color: #059669; }
        .status-completada { background-color: #dbeafe; color: #1d4ed8; }
        .status-cancelada { background-color: #fee2e2; color: #dc2626; }

        .cutting-line {
            border-top: 2px dashed #c5a880;
            margin: 25px 0;
            position: relative;
            text-align: center;
        }
        .scissors {
            position: absolute;
            top: -10px;
            left: 20px;
            background-color: #fafafa;
            padding: 0 5px;
            color: #c5a880;
            font-size: 14px;
        }
        .footer {
            text-align: center;
        }
        .footer-message {
            font-size: 13px;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 10px;
        }
        .footer-terms {
            font-size: 10px;
            color: #888888;
            line-height: 1.4;
        }
        /* Barcode CSS Simulation */
        .barcode {
            margin: 20px auto 10px auto;
            width: 180px;
            height: 35px;
            border-left: 2px solid #000;
            border-right: 1px solid #000;
            box-sizing: border-box;
            background: repeating-linear-gradient(
                90deg,
                #000,
                #000 2px,
                transparent 2px,
                transparent 4px,
                #000 4px,
                #000 5px,
                transparent 5px,
                transparent 8px
            );
        }
        .barcode-number {
            font-family: monospace;
            font-size: 10px;
            letter-spacing: 3px;
            color: #666666;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="ticket-container">
    <div class="barber-pole"></div>

    <div class="header">
        <h1 class="logo-title">Olan</h1>
        <p class="logo-subtitle">BarberShop</p>
        <div class="divider-gold"></div>
        <p class="ticket-info">
            Calle Principal #123, Centro<br>
            Teléfono: 991-109-9943<br>
            <strong>COMPROBANTE DE CITA</strong>
        </p>
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Código de Cita</td>
            <td class="value" style="font-family: monospace; font-weight: bold; font-size: 14px;">
                #OB-{{ str_pad($appointment->id, 5, '0', STR_PAD_LEFT) }}
            </td>
        </tr>
        <tr>
            <td class="label">Cliente</td>
            <td class="value">{{ $appointment->user->name }}</td>
        </tr>
        <tr>
            <td class="label">Barbero</td>
            <td class="value">{{ $appointment->barber->name }}</td>
        </tr>
        <tr>
            <td class="label">Fecha</td>
            <td class="value">{{ \Carbon\Carbon::parse($appointment->fecha)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="label">Hora</td>
            <td class="value">{{ \Carbon\Carbon::parse($appointment->hora)->format('g:i A') }}</td>
        </tr>
        <tr>
            <td class="label">Estado</td>
            <td class="value">
                <span class="status-badge status-{{ $appointment->estado }}">
                    {{ $appointment->estado }}
                </span>
            </td>
        </tr>
        <tr>
            <td class="label" style="border: none; padding-top: 15px;">Servicio</td>
            <td class="value" style="border: none; padding-top: 15px; font-weight: bold;">
                {{ $appointment->service->nombre }}
            </td>
        </tr>
        <tr>
            <td class="label" style="border: none;">Total a Pagar</td>
            <td class="price" style="border: none;">
                ${{ number_format($appointment->service->precio, 2) }}
            </td>
        </tr>
    </table>

    <div class="cutting-line">
        <span class="scissors">&#9986; Recortar</span>
    </div>

    <div class="footer">
        <p class="footer-message">¡Gracias por tu preferencia!</p>
        
        <div class="barcode"></div>
        <div class="barcode-number">OB{{ str_pad($appointment->id, 8, '0', STR_PAD_LEFT) }}</div>

        <p class="footer-terms">
            * Favor de llegar 5 minutos antes de su cita.<br>
            * En caso de cancelación, avisar con 2 horas de anticipación.<br>
            * El comprobante es válido únicamente para la fecha y hora impresa.
        </p>
    </div>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Cita - Olan BarberShop</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f4f5;
            color: #333333;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .email-wrapper {
            width: 100%;
            background-color: #f4f4f5;
            padding: 40px 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #e4e4e7;
        }
        .barber-pole-stripe {
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
        }
        .email-header {
            background-color: #121215;
            padding: 35px 20px;
            text-align: center;
            border-bottom: 3px solid #c5a880;
        }
        .logo-title {
            font-size: 28px;
            font-weight: 900;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin: 0;
        }
        .logo-subtitle {
            font-size: 11px;
            color: #c5a880;
            text-transform: uppercase;
            letter-spacing: 5px;
            margin: 5px 0 0 0;
            font-weight: bold;
        }
        .email-body {
            padding: 40px 30px;
        }
        .welcome-title {
            font-size: 22px;
            font-weight: bold;
            color: #121215;
            margin-top: 0;
            margin-bottom: 15px;
        }
        .intro-text {
            font-size: 15px;
            color: #52525b;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .details-box {
            background-color: #fafafa;
            border: 1px solid #e4e4e7;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
        }
        .details-title {
            font-size: 14px;
            font-weight: bold;
            color: #c5a880;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #e4e4e7;
            pb: 10px;
            padding-bottom: 10px;
        }
        .detail-row {
            margin-bottom: 15px;
            font-size: 15px;
        }
        .detail-row:last-child {
            margin-bottom: 0;
        }
        .detail-label {
            font-weight: bold;
            color: #71717a;
            display: inline-block;
            width: 120px;
        }
        .detail-value {
            color: #18181b;
            font-weight: 500;
        }
        .detail-price {
            font-size: 18px;
            font-weight: bold;
            color: #a2835b;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-pendiente { background-color: #fef3c7; color: #d97706; }
        .badge-confirmada { background-color: #d1fae5; color: #059669; }
        .badge-completada { background-color: #dbeafe; color: #1d4ed8; }
        .badge-cancelada { background-color: #fee2e2; color: #dc2626; }

        .notice-card {
            background-color: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 15px 20px;
            border-radius: 0 8px 8px 0;
            margin-bottom: 30px;
            font-size: 14px;
            color: #1e40af;
            line-height: 1.5;
        }
        .email-footer {
            background-color: #121215;
            padding: 30px 20px;
            text-align: center;
            color: #a1a1aa;
            font-size: 12px;
            line-height: 1.5;
            border-top: 1px solid #27272a;
        }
        .footer-logo {
            font-weight: bold;
            color: #ffffff;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        .footer-info {
            margin-bottom: 15px;
        }
        .footer-copyright {
            font-size: 11px;
            color: #71717a;
        }
    </style>
</head>
<body>

<div class="email-wrapper">
    <div class="email-container">
        <div class="barber-pole-stripe"></div>
        
        <div class="email-header">
            <h1 class="logo-title">Olan</h1>
            <p class="logo-subtitle">BarberShop</p>
        </div>

        <div class="email-body">
            <h2 class="welcome-title">¡Hola, {{ $appointment->user->name }}!</h2>
            <p class="intro-text">
                Confirmamos que tu cita ha sido registrada con éxito en nuestro sistema. A continuación, te compartimos los detalles de tu reservación para que los tengas a la mano.
            </p>

            <div class="details-box">
                <h3 class="details-title">Resumen de tu Cita</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Servicio:</span>
                    <span class="detail-value" style="font-weight: bold;">{{ $appointment->service->nombre }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Barbero:</span>
                    <span class="detail-value">{{ $appointment->barber->name }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Fecha:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($appointment->fecha)->format('d/m/Y') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Hora:</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($appointment->hora)->format('g:i A') }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Estado:</span>
                    <span class="badge badge-{{ $appointment->estado }}">{{ $appointment->estado }}</span>
                </div>

                <div class="detail-row" style="margin-top: 20px; padding-top: 15px; border-top: 1px dashed #e4e4e7;">
                    <span class="detail-label">Total a pagar:</span>
                    <span class="detail-price">${{ number_format($appointment->service->precio, 2) }}</span>
                </div>
            </div>

            <div class="notice-card">
                <strong>💡 Recomendación importante:</strong><br>
                Por favor llega 5 minutos antes de la hora acordada. En caso de que necesites cancelar o reprogramar, te pedimos de favor que nos avises con al menos 2 horas de anticipación.
            </div>
            
            <p class="intro-text" style="margin-bottom: 0;">
                Si tienes alguna pregunta o requieres realizar alguna modificación en tu reservación, no dudes en responder directamente a este correo o contactarnos al número telefónico de la sucursal.
            </p>
        </div>

        <div class="email-footer">
            <div class="footer-logo">OLAN BARBERSHOP</div>
            <div class="footer-info">
                Calle Principal #123, Centro, México<br>
                Teléfono: 991-109-9943
            </div>
            <div class="footer-copyright">
                &copy; {{ date('Y') }} Olan BarberShop. Todos los derechos reservados.
            </div>
        </div>
    </div>
</div>

</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Formulario</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            display: flex; /* Hace que los elementos hijos se coloquen en línea */
        }

        h1 {
            color: #1633EE; /* Cambia el color del título a rojo */
            border-bottom: 2px solid blue; /* Cambia el color de la línea inferior a rojo */
            padding-bottom: 10px;
        }

        p {
            margin: 5px 0;
        }

        .form-info {
            margin-bottom: 20px;
        }

        .billing-info {
            margin-top: 30px;
        }
        /* Agrega más estilos según sea necesario */
    </style>
</head>
<body>
    <div class="form-info">
        <h1><strong>Información del Formulario</strong></h1>

        <p><strong>Email:</strong> {{ $formData['email'] }}</p>
        <p><strong>Clave:</strong> ********</p>
        <p><strong>Confirmar Clave:</strong> ********</p>
        <p><strong>Primer Nombre:</strong> {{ $formData['first_name'] }}</p>
        <p><strong>Apellido:</strong> {{ $formData['last_name'] }}</p>
        <p><strong>Empresa (opcional):</strong> {{ $formData['company'] }}</p>
        <p><strong>Telefono:</strong> {{ $formData['phone_number'] }}</p>
        <p><strong>Pregunta seguridad:</strong> {{ $formData['security_question'] }}</p>
    </div>

    <div class="billing-info">
        <h1><strong>Datos de Facturación</strong></h1>

        <p><strong>Número de Factura:</strong> {{ $invoiceData['invoice_number'] }}</p>
        <p><strong>Fecha:</strong> {{ $invoiceData['date'] }}</p>
        <p><strong>Total:</strong> ${{ $invoiceData['total'] }}</p>
        <strong>... otros datos de facturación </strong>
    </div>
</body>
</html>

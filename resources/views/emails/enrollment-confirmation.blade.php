<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmación de Inscripción</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #4f46e5; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { padding: 20px; background-color: #f9fafb; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 8px 8px; }
        .details { background-color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #e5e7eb; }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #6b7280; }
        .button { display: inline-block; padding: 10px 20px; background-color: #4f46e5; color: white; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Inscripción Confirmada!</h1>
        </div>
        
        <div class="content">
            <p>Hola {{ $student->first_name }},</p>
            <p>Gracias por inscribirte en nuestro curso. Aquí tienes los detalles de tu inscripción:</p>
            
            <div class="details">
                <h2 style="margin-top: 0;">Detalles del Curso</h2>
                <p><strong>Academia:</strong> {{ $academy->name }}</p>
                <p><strong>Curso:</strong> {{ $course->name }}</p>
                <p><strong>Fecha de Inscripción:</strong> {{ $enrollment->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Código de Inscripción:</strong> {{ $enrollment->id }}</p>
                
                @if($enrollment->pays->isNotEmpty())
                    <h3 style="margin-bottom: 5px;">Información de Pago</h3>
                    <p><strong>Método:</strong> {{ ucfirst(str_replace('_', ' ', $enrollment->pays->first()->method)) }}</p>
                    <p><strong>Monto:</strong> ${{ number_format($enrollment->pays->first()->amount, 2) }}</p>
                    <p><strong>Estado:</strong> Completado</p>
                @endif
            </div>
            
            <p>Si tienes alguna pregunta sobre tu inscripción, no dudes en contactarnos respondiendo a este correo.</p>
            
            <p style="text-align: center; margin-top: 30px;">
                <a href="{{ route('enrollment.confirmation', $enrollment->id) }}" class="button">Ver Detalles de Inscripción</a>
            </p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} {{ $academy->name }}. Todos los derechos reservados.</p>
            <p>
                {{ $academy->address }}<br>
                Teléfono: {{ $academy->phone }} | Email: {{ $academy->email }}
            </p>
        </div>
    </div>
</body>
</html>
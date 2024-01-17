<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FormController extends Controller
{
    // Función para procesar el formulario enviado
    public function submitForm(Request $request)
    {
        try {
            // Reglas de validación para el formulario
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:8',
                'confirmation_password' => 'required|same:password',
                'first_name' => 'required',
                'last_name' => 'required',
                'company' => 'nullable',
                'phone_number' => 'required',
                'security_question' => 'required|in:Pepito,Juanito,Pablito,Pedrito',
            ]);

            // Lógica para procesar el formulario y obtener datos
            $processedData = [
                'processed_field_1' => strtoupper($request->input('first_name')),
                'processed_field_2' => $request->input('last_name'),
                'processed_company' => $request->input('company') ? strtoupper($request->input('company')) : null,
                'processed_phone_number' => $request->input('phone_number'),
                'processed_security_question' => $request->input('security_question'),
            ];

            // Datos aleatorios de facturación 
            $invoiceData = [
                'invoice_number' => mt_rand(1000, 9999),
                'date' => now()->format('Y-m-d'),
                'total' => mt_rand(100, 1000),
                'customer_name' => $processedData['processed_field_1'] . ' ' . $processedData['processed_field_2'],
            ];

            // Combina los datos del formulario y los procesados
            $formData = array_merge($request->all(), $processedData);

            //obtener el token 
            $token = $request->input('_token');

            // Generar PDF utilizando la librería DomPDF y la vista 'pdf.invoice'
            $pdf = Pdf::loadView('pdf.invoice', compact('formData', 'invoiceData'));

            // Descarga el PDF con un nombre específico

            return $pdf->download('formulario.pdf', [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename=formulario.pdf',
            ]);

        } catch (\Exception $e) {
            // Registra información detallada sobre la excepción
            \Log::error('Error al procesar el formulario: ' . $e->getMessage());
            \Log::error('Exception Type: ' . get_class($e));
            \Log::error('Stack Trace: ' . $e->getTraceAsString());

            // Devuelve una respuesta de error detallada 
            return response()->json(['error' => 'Error al procesar el formulario', 'exception' => $e->getMessage()], 500);
        }
    }
}

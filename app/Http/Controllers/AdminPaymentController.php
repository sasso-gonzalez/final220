<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Appointment;
use Carbon\Carbon; // for date calculations

class AdminPaymentController extends Controller
{
    /**
     * Display the admin payment page.
     */
    public function index()
    {
        return view('adminPayment');
    }

    /**
     * Handle payment cancellation.
     */
    public function cancel()
    {
        return redirect()->back()->with('info', 'Patient Payment Canceled.');
    }

    /**
     * Submit a payment for a patient.
     */
    public function submitPayment(Request $request)
    {
        $request->validate([
            'patientID' => 'required|exists:patients,patient_id',
            'paymentAmount' => 'required|numeric|min:0',
        ]);

        $patientID = $request->input('patientID');
        $paymentAmount = $request->input('paymentAmount');

        $patient = Patient::where('patient_id', $patientID)->first();

        if (!$patient) {
            return redirect()->back()->with('error', 'Patient not found.');
        }

        if ($patient->amount_due <= 0) {
            return redirect()->back()->with('error', 'No payment due for this patient.');
        }

        $currentDate = Carbon::now()->subDay(); // use the day before today to avoid grab todays appointment if its not been attended yet
        $paymentDate = $patient->payment_date ?? $patient->admission_date;

        $newCharges = $this->calculateTotalDue($patientID, $paymentDate, $currentDate);

        // updating patient payment info
        $patient->amount_due += $newCharges;
        $patient->amount_due -= $paymentAmount;
        $patient->payment_date = $currentDate;
        $patient->save();

        \Log::info('Payment submitted', [
            'patient_id' => $patientID,
            'payment_amount' => $paymentAmount,
            'new_amount_due' => $patient->amount_due,
            'new_payment_date' => $patient->payment_date,
        ]);

        return redirect()->back()->with('success', 'Payment updated successfully.');
    }

    /**
     * Fetch payment details for a patient.
     */
    public function fetchPaymentDetails($id)
    {
        try {    
            $patient = Patient::where('patient_id', $id)->first();

            if (!$patient) {
                return response()->json(['error' => 'Patient not found'], 404);
            }

            $paymentDate = $patient->payment_date;

            if (!$paymentDate instanceof Carbon) {
                $paymentDate = Carbon::parse($paymentDate);
            }

            return response()->json([
                'patient_id' => $patient->patient_id,
                'payment_date' => $paymentDate->toDateString(),
                'amount_due' => $patient->amount_due,
            ]);

        } catch (\Exception $e) {
            \Log::error('Error fetching payment details', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update charges for a patient.
     */
    public function updateCharges(Request $request)
    {
        try {
            $patientID = $request->input('patientID');

            $patient = Patient::where('patient_id', $patientID)->first();

            if (!$patient) {
                \Log::error('Patient not found', ['patient_id' => $patientID]);
                return response()->json(['error' => 'Patient not found'], 404);
            }

            $currentDate = Carbon::now()->subDay(); // Use the day before today
            $paymentDate = $patient->payment_date ?? $patient->admission_date;

            $newCharges = $this->calculateTotalDue($patientID, $paymentDate, $currentDate);

            // Update patient payment info
            $amountDue = $patient->amount_due;
            $patient->amount_due = $amountDue + $newCharges;
            $patient->payment_date = $currentDate;
            $patient->save();

            \Log::info('Charges updated', [
                'patient_id' => $patientID,
                'new_amount_due' => $patient->amount_due,
                'new_payment_date' => $patient->payment_date,
            ]);

            return response()->json([
                'payment_date' => $patient->payment_date->toDateString(),
                'amount_due' => $patient->amount_due,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error updating charges', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Calculate the total due amount for a patient.
     */
    public function calculateTotalDue($patientID, $paymentDate, $currentDate)
    {
        // calculating days stayed in the hospital
        $daysStayed = $currentDate->diffInDays($paymentDate);
        $hospitalCost = $daysStayed * 10;

        // calculating appointment costs
        $appointments = Appointment::where('patient_id', $patientID)
            ->whereBetween('app_date', [$paymentDate, $currentDate])
            ->count();
        $appointmentCost = $appointments * 50;

        return $hospitalCost + $appointmentCost;
    }
}

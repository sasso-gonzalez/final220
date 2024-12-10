<style>
    /* public/css/adminPayment.css */

.container {
    max-width: 600px;
    margin: 0 auto;
    background-color: #f9f9f9;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

form {
    display: flex;
    flex-direction: column;
}

form label {
    font-size: 14px;
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
}

form input[type="text"],
form input[type="number"] {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 15px;
    background-color: #fff;
}

form input[readonly] {
    background-color: #f5f5f5;
    color: #666;
}

form button {
    padding: 10px 15px;
    font-size: 14px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-right: 10px;
    margin-bottom: 10px;
    transition: all 0.3s ease;
}

form button:hover {
    opacity: 0.9;
}

form button[type="submit"] {
    background-color: #4CAF50; /* Green */
    color: white;
}

form button[type="button"]:not([onclick*="updateCharges"]) {
    background-color: #f44336; /* Red */
    color: white;
}

form button[onclick*="updateCharges"] {
    background-color: #ffa500; /* Orange */
    color: white;
}

form button:disabled {
    background-color: #ddd;
    color: #aaa;
    cursor: not-allowed;
}

@media (max-width: 600px) {
    form input[type="text"],
    form input[type="number"] {
        font-size: 12px;
    }

    form button {
        font-size: 12px;
        padding: 8px 12px;
    }
}

</style>
@extends('layouts.app')
@include('layouts.navigation')

<br><br><br>
@section('content')
<div class="container">
    <h1>Admin Payment Page</h1>
    <form action="{{ route('admin.payment.submit') }}" method="POST">
        @csrf
        <label for="patientID">Patient ID:</label>
        <input type="text" id="patientID" name="patientID" onblur="fetchPaymentDetails()" required><br><br>

        <label for="paymentDate">Payment Starting Date:</label>
        <input type="text" id="paymentDate" name="paymentDate" readonly><br><br>

        <label for="paymentDue">Payment Due:</label>
        <input type="text" id="paymentDue" name="paymentDue" readonly><br><br>

        <label for="paymentAmount">Payment Amount:</label>
        <input type="number" id="paymentAmount" name="paymentAmount" required><br><br>

        <button type="button" onclick="window.location.href='{{ route('admin.payment.cancel') }}'">Cancel</button>
        <button type="submit" id="submitPaymentButton" disabled>Submit</button>
        <button type="button" onclick="updateCharges()">Update</button>
    </form>
</div>

<script>
    function fetchPaymentDetails() {
        const patientID = document.getElementById('patientID').value;

        if (patientID) {
            console.log('Fetching payment details for patient ID:', patientID); // Debugging

            fetch(`/api/patients/${patientID}/payment-details`)
                .then(response => {
                    if (!response.ok) throw new Error('Error fetching payment details');
                    return response.json();
                })
                .then(data => {
                    console.log('Payment details fetched:', data); // Debugging
                    document.getElementById('paymentDate').value = data.payment_date;
                    document.getElementById('paymentDue').value = data.amount_due;
                    document.getElementById('submitPaymentButton').disabled = (parseFloat(data.amount_due) <= 0);
                })
                .catch(error => {
                    alert('Unable to fetch payment details. Please check the Patient ID.');
                    console.error('Fetch error:', error); // Debugging
                });
        } else {
            alert('Please enter a Patient ID.');
        }
    }

    function updateCharges() {
        const patientID = document.getElementById('patientID').value;

        if (patientID) {
            fetch(`/api/patients/${patientID}/update-charges`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ patientID })
            })
            .then(response => {
                if (!response.ok) throw new Error('Error updating charges');
                return response.json();
            })
            .then(data => {
                alert('Charges updated successfully.');
                document.getElementById('paymentDate').value = data.payment_date;
                document.getElementById('paymentDue').value = data.amount_due;
                document.getElementById('submitPaymentButton').disabled = (parseFloat(data.amount_due) <= 0);
            })
            .catch(error => {
                alert('Unable to update charges. Please try again.');
                console.error('Update error:', error); // Debugging
            });
        } else {
            alert('Please enter a Patient ID.');
        }
    }
</script> 
@endsection
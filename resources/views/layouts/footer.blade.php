<link href="{{ asset('css/footer.css') }}" rel="stylesheet">

<footer class="footer">
    <div class="footer-content">
        <div class="footer-section about">
            <h3>About Us</h3>
            <p>Your doctor's office website providing the best healthcare solutions for what our employees call, "The Wrinkle Ranch."</p>
        </div>

        <div class="footer-section links">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="{{ route('welcome') }}">Home</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
                <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
            </ul>
        </div>

        <div class="footer-section contact">
            <h3>Contact Us</h3>
            <p>Email: info@doctorsite.com</p>
            <p>Phone: (123) 456-7890</p>
            <p>Address: 123 Main Street, City, Country</p>
        </div>
    </div>

    <div class="footer-bottom">
        &copy; {{ date('Y') }} Silver Cross Medical Center. All rights reserved.
    </div>
</footer>

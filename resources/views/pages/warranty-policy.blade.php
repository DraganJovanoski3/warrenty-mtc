<x-public-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white border border-slate-200 rounded-lg p-6 sm:p-8 space-y-5 text-sm text-slate-700 leading-relaxed">
            <h1 class="text-xl font-semibold text-slate-900">Warranty Policy</h1>

            @php
                $contact = config('services.mtc.warranty_contact_email', 'warranty@mtctruckparts.com');
            @endphp

            <div class="rounded-md bg-amber-50 border border-amber-200 px-4 py-3 text-amber-950 space-y-2">
                <p class="font-semibold">Claim within 30 days of purchase</p>
                <p>
                    Customers must register / claim their warranty within <strong>30 days</strong> of the purchase date.
                    Submissions after this period may not be eligible for warranty coverage.
                </p>
                <p>
                    After you submit the form, you will receive a confirmation email with the details you entered.
                    If you find a mistake, contact
                    <a href="mailto:{{ $contact }}" class="underline font-medium">{{ $contact }}</a>
                    within those same <strong>30 days of purchase</strong> so MTC can correct your warranty record.
                </p>
            </div>

            <p>
                To register an installation and warranty claim, complete the Installation Information &amp; Proof of
                Application form, provide a valid email address, and upload clear photos of the VIN plate and odometer.
            </p>
            <ul class="list-disc ps-5 space-y-2">
                <li>Provide accurate company, email, truck, and part details.</li>
                <li>Enter the correct purchase / invoice date.</li>
                <li>Upload required VIN and mileage proof photos.</li>
                <li>Submit the form as soon as possible after installation — no later than 30 days from purchase.</li>
                <li>Review your confirmation email and report corrections to {{ $contact }} within 30 days of purchase.</li>
            </ul>
            <p>
                MTC Truck Parts reviews submitted records for warranty eligibility. Incomplete or inaccurate
                submissions may delay or invalidate a claim.
            </p>
            <p>
                <a href="{{ route('public.form') }}" class="text-amber-700 hover:underline font-medium">Return to the registration form</a>
            </p>

            <div class="pt-4 border-t border-slate-200 text-xs text-slate-500">
                <p>Warranty Tracker application developed by Dragan Jovanoski — DD Solutions.</p>
                <a href="https://ddsolutions.com.mk/" class="text-amber-700 hover:underline" target="_blank" rel="noopener">https://ddsolutions.com.mk/</a>
            </div>
        </div>
    </div>
</x-public-layout>

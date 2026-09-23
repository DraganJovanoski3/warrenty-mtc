<x-mail::message>
# Warranty Claim Confirmation

Thank you. We received your installation / warranty claim **#{{ $installation->id }}**.

Please review the details below carefully. If anything is incorrect, contact us at [{{ $contactEmail }}](mailto:{{ $contactEmail }}) within **30 days of purchase** so we can correct your record.

## Customer / Company
- **Company:** {{ $installation->company_name }}
- **Email:** {{ $installation->customer_email }}
- **Tax ID:** {{ $installation->tax_id ?: '—' }}
- **Address:** {{ $installation->customer_address }}
- **Installer company:** {{ $installation->installer_company_name }}

## Truck
- **Truck number:** {{ $installation->truck_number }}
- **VIN:** {{ $installation->vin }}
- **Mileage at installation:** {{ $installation->mileage_at_installation ?? '—' }}
- **Installation date:** {{ optional($installation->installation_date)->format('Y-m-d') }}

## Part & Purchase
- **Part number:** {{ $installation->part_number }}
- **Description:** {{ $installation->part_description }}
- **Invoice number:** {{ $installation->invoice_number ?: '—' }}
- **Purchase date:** {{ optional($installation->invoice_date)->format('Y-m-d') ?: '—' }}
- **Submitted at:** {{ optional($installation->submitted_at)->format('Y-m-d H:i') }}

VIN plate and odometer proof photos were received with this claim.

Questions or corrections: [{{ $contactEmail }}](mailto:{{ $contactEmail }})

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

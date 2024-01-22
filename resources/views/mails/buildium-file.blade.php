@extends('layouts.mail')

@section('content')
    <div class="container">
        <p>
            Hi Sterling Admin,
        </p>
        @if($unit)
            <p>
                <a href="https://sterlingmgmt.managebuilding.com/Resident/rental-application/new/apply?listingId={{$unit->Id}}">
                    {{$unit->formatted_address}}
                </a>
            </p>
        @endif
        <p>
            Please review the attached files for further process.
        </p>
        <p>
            Thanks.
        </p>
        <p>
            Sterling Online Forms & Resources Hub
        </p>
    </div>
@endsection
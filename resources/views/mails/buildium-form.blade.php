@extends('layouts.mail')

@section('content')
    <section class="page-section">
        <div class="container">
            <h3 class="text-center mb-4">{{$form->title}}</h3>
            <div>
                <table border="1" style="border-collapse: collapse; border-color: #0A246A; width: 100%;">
                    @foreach($fields as $key=>$val)
                        <tr>
                            <th style="padding: 10px; text-align: left; width: 30%;">{{$key}}</th>
                            <td style="padding: 10px;">{{$val}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </section>
@endsection
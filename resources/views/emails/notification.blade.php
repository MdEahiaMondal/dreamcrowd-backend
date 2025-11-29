@extends('emails.layouts.base')

@section('title', $notification['title'] ?? 'Notification')

@section('header_title', $notification['title'] ?? 'Notification')

@section('content')
    @if(isset($notification['is_emergency']) && $notification['is_emergency'])
        <div class="alert-box">
            <p><strong>⚠ Important Notification</strong></p>
        </div>
    @endif

    <p class="lead">Hello,</p>

    <p>{!! nl2br(e($notification['message'])) !!}</p>

    @if(isset($notification['data']) && is_array($notification['data']))
        @if(count($notification['data']) > 0)
            <div class="info-box">
                <p><strong>Details:</strong></p>
                @foreach($notification['data'] as $key => $value)
                    @if(!in_array($key, ['order_id', 'service_id', 'seller_id', 'buyer_id']) && !is_array($value))
                        <p><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</p>
                    @endif
                @endforeach
            </div>
        @endif
    @endif

    @if(isset($notification['data']['order_id']))
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
                <td align="center">
                    <a href="{{ url('/user-application-details/' . $notification['data']['order_id']) }}" class="btn btn-primary">
                        View Order Details
                    </a>
                </td>
            </tr>
        </table>
    @endif

    <div class="divider"></div>

    <p style="color: #777; font-size: 13px;">
        <em>This notification was sent because an action occurred on your {{ config('app.name', 'DreamCrowd') }} account. If you have any questions, please contact our support team.</em>
    </p>
@endsection

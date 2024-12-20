<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="color-scheme" content="light" />
        <meta name="supported-color-schemes" content="light" />
        <title>{{ __('emails/ticket.title') }}</title>

        <link rel="stylesheet" href="style.css" />
    </head>

    <body>
        <div
            style="
                background-image: url(&quot;https://kappa.lol/OPr8l&quot;);
                background-size: cover;
                padding-top: 30px;
                padding-bottom: 30px;
            "
        >
            <div
                style="
                    width: 100%;
                    max-width: 600px;
                    min-height: 406px;
                    border-radius: 4px;
                    background-color: #ffffff;
                    color: #000000;
                    margin: auto;
                    position: relative;
                    padding-bottom: 20px;
                "
                class="container"
            >
                <div
                    style="width: 100%; height: 12px; background-color: #ff8d45"
                ></div>

                <!-- <img src="https://kappa.lol/6Ihyf" class="reference" alt=""> -->
                <h2
                    style="
                        font-size: 21px;
                        font-weight: 300;
                        line-height: 20px;
                        color: #344760;
                        font-family: Arial, sans-serif;
                        text-align: center;
                        margin-top: 16px;
                    "
                >
					{{ __('emails/ticket.h1') }}
                    <span
                        style="
                            font-size: 21px;
                            line-height: 20px;
                            color: #ddc000;
                            font-family: Arial, sans-serif;
                            text-align: center;
                        "
                        >private-new-education<img
                            src=""
                            width="0"
                            height="0"
                        />.com</span
                    >
                </h2>

                <div
                    style="
                        font-size: 16px;
                        line-height: 12px;
                        color: #344760;
                        font-family: Arial, sans-serif;
                        text-align: center;
                        margin-top: 24px;
                    "
                >
                    {{ __('emails/ticket.1') }}{{ $subscription->payment->id }}<img src="" width="0" height="0" />
                </div>

                <table
                    style="
                        width: 100%;
                        max-width: 516px;
                        margin: auto;
                        margin-top: 40px;
                    "
                >
                    <tbody>
                        <tr>
                            <td
                                valign="top"
                                style="
                                    font-size: 14px;
                                    line-height: 19px;
                                    color: #70aac2;
                                    font-weight: bold;
                                    font-family: Arial, sans-serif;
                                    width: 36%;
                                "
                            >
							{{ __('emails/ticket.2') }}
                            </td>

                            <td
                                valign="top"
                                style="
                                    font-size: 14px;
                                    line-height: 19px;
                                    color: #70aac2;
                                    font-weight: bold;
                                    font-family: Arial, sans-serif;
                                    width: 38.8%;
                                "
                            >
							{{ __('emails/ticket.3') }}
                            </td>
                            <td
                                valign="top"
                                style="
                                    font-size: 13px;
                                    line-height: 19px;
                                    color: #70aac2;
                                    font-weight: bold;
                                    font-family: Arial, sans-serif;
                                "
                            >
							{{ __('emails/ticket.4') }}
                            </td>
                        </tr>

                        <tr>
                            <td
                                style="
                                    font-size: 14px;
                                    line-height: 10px;
                                    color: #344760;
                                    font-family: Arial, sans-serif;
                                    /* margin-top: 5px; */
                                    font-weight: 500;
                                "
                            >
                                {{ $subscription->payment->amount }}
                            </td>
                            <td
                                style="
                                    font-size: 14px;
                                    line-height: 15px;
                                    color: #344760;
                                    font-family: Arial, sans-serif;
                                    margin-top: 5px;
                                    font-weight: 500;
                                    padding-top: 9px;
                                "
                            >
								@if (app()->getLocale() == 'ru')
                                    {{ $subscription->payment->created_at->translatedFormat('j F Y') }}
								@else
									{{ $subscription->payment->created_at->translatedFormat('F d, Y') }}
								@endif
                            </td>
                            <td
                                style="
                                    font-size: 15px;
                                    line-height: 18px;
                                    color: #344760;
                                    font-family: Arial, sans-serif;
                                    /* width: 38.8%; */
                                    padding-top: 4px;
                                "
                            >
                                <span
                                    style="
                                        background: #ff8d45;
                                        width: 54px;
                                        height: 17px;
                                        display: inline-block;
                                        margin-right: 3px;
                                        margin-top: 1px;
                                    "
                                ></span
                                >{{ __('emails/ticket.5') }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div
                    style="
                        border-bottom: 1px solid #b8d2d2;
                        padding-bottom: 12px;
                        max-width: 512px;
                        margin: auto;
                    "
                >
                    <h3
                        style="
                            font-size: 14px;
                            line-height: 5px;
                            color: #70aac2;
                            font-weight: 500;
                            font-family: Arial, sans-serif;
                            text-align: left;
                            margin-top: 31px;
                        "
                    >
					{{ __('emails/ticket.6') }}
                    </h3>

                    <table
                        style="
                            min-height: 92px;
                            border-radius: 17px;
                            border: 1px solid #70aac2;
                            margin-top: 17px;
                            padding: 1px 12px;
                            display: flex;
                            justify-content: space-between;
                        "
                    >
                        <tbody style="width: 100%">
                            <tr>
                                <td
                                    style="
                                        font-size: 16px;
                                        line-height: 18px;
                                        color: #344760;
                                        font-family: Arial, sans-serif;
                                        margin-bottom: 0px;
                                        width: 60%;
                                    "
                                >
                                    <div style="margin-bottom: 5px">
										@if ($subscription->subscribable_type === 'video')
                                        {{ __('emails/ticket.7') }} <br />
                                        {{ __('emails/ticket.8') }}
										@else
										{{ __('emails/ticket.9') }} <br />
                                        {{ __('emails/ticket.10') }}
										@endif
                                    </div>
                                    <div
                                        style="
                                            font-size: 15px;
                                            line-height: 16px;
                                            color: #ffffff;
                                            font-family:
                                                Times New Roman,
                                                serif;
                                            text-align: center;
                                            width: 105px;
                                            padding-top: 7px;
                                            padding-bottom: 8px;
                                            background-color: #ff8d45;
                                            background: #ff8d45;
                                            border: none;
                                        "
                                    >
                                        {{ __('emails/ticket.11') }}{{ $subscription->subscribable_id }}
                                    </div>
                                </td>
                                <td
                                    style="
                                        font-size: 22px;
                                        line-height: 24px;
                                        color: #344760;
                                        font-family: Arial, sans-serif;
                                        text-align: right;
                                        width: 40%;
                                    "
                                >
                                    {{ $subscription->payment->amount }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <table
                    style="
                        max-width: 516px;
                        margin: auto;
                        table-layout: fixed;
                        font-size: 20px;
                        line-height: 24px;
                        color: #faae8c;
                        font-family: Arial, sans-serif;
                        text-align: center;
                        margin-top: 19px;
                        /* padding-left: 35px; */
                        /* padding-right: 20px; */
                        width: 100%;
                    "
                >
                    <tbody>
                        <tr style="">
                            <td
                                style="
                                    font-size: 20px;
                                    line-height: 18px;
                                    color: #faae8c;
                                    font-weight: bold;
                                    font-family: Arial, sans-serif;
                                    text-align: left;
                                    width: 30%;
                                    /* padding-left: 8px; */
                                "
                            >
                                {{ __('emails/ticket.12') }}
                            </td>
                            <!-- Spacer column to fill the gap -->
                            <td
                                style="
                                    font-size: 40px;
                                    line-height: 18px;
                                    color: #faae8c;
                                    font-family: Arial, sans-serif;
                                    text-align: right;
                                    width: 70%;
                                    /* padding-right: 23px; */
                                "
                            >
                                {{ $subscription->payment->amount }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>

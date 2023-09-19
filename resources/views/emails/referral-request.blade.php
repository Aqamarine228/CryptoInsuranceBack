<!doctype html>
<html lang="{{locale()->current()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{__('emails.referralRequest.pageTitle', [], $locale)}}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{Module::asset('client:images/favicons/favicon.ico')}}">
</head>

<body style="display: flex; align-items: center; justify-content: center; align-content: center; height: 100vh">

<!-- Begin page -->
<div id="layout-wrapper">

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <table class="body-wrap"
                               style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: transparent; margin: 0;">
                            <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <td style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
                                    valign="top"></td>
                                <td class="container" width="600"
                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
                                    valign="top">
                                    <div class="content"
                                         style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                                        <table class="main" width="100%" cellpadding="0" cellspacing="0"
                                               itemprop="action" itemscope itemtype="http://schema.org/ConfirmAction"
                                               style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; margin: 0; border: none;">
                                            <tr style="font-family: 'Roboto', sans-serif; font-size: 14px; margin: 0;">
                                                <td class="content-wrap"
                                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; color: #495057; font-size: 14px; vertical-align: top; margin: 0;padding: 30px; box-shadow: 0 3px 15px rgba(30,32,37,.06); ;border-radius: 7px; background-color: #fff;"
                                                    valign="top">
                                                    <table width="100%" cellpadding="0" cellspacing="0"
                                                           style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                        <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                            <td class="content-block"
                                                                style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 0px;"
                                                                valign="top">
                                                                <div style="text-align: center;margin-bottom: 15px;">
                                                                    <img src="{{Module::asset('client:images/resources/logo-3.png')}}" alt=""
                                                                         height="50">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @if($status === \App\Enums\ReferralRequestStatus::APPROVED)
                                                            <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                                <td class="content-block"
                                                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 24px; vertical-align: top; margin: 0; padding: 0 0 10px;  text-align: center;"
                                                                    valign="top">
                                                                    <h4 style="font-family: 'Roboto', sans-serif; font-weight: 500;">
                                                                        {{__("emails.referralRequest.title.approved", [], $locale)}}
                                                                    </h4>
                                                                </td>
                                                            </tr>
                                                            <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                                <td class="content-block"
                                                                    style="font-family: 'Roboto', sans-serif; color: #878a99; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 26px; text-align: center;"
                                                                    valign="top">
                                                                    {{__("emails.referralRequest.description.approved", [], $locale)}}
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        @else
                                                            <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                                <td class="content-block"
                                                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 24px; vertical-align: top; margin: 0; padding: 0 0 10px;  text-align: center;"
                                                                    valign="top">
                                                                    <h4 style="font-family: 'Roboto', sans-serif; font-weight: 500;">
                                                                        {{__("emails.referralRequest.title.declined", [], $locale)}}
                                                                    </h4>
                                                                </td>
                                                            </tr>
                                                            <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                                <td class="content-block"
                                                                    style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 24px; vertical-align: top; margin: 0; padding: 0 0 10px;  text-align: center;"
                                                                    valign="top">
                                                                    <h6 style="font-family: 'Roboto', sans-serif; font-weight: 500;">
                                                                        {{__("emails.referralRequest.declinationReason", [], $locale)}}:
                                                                    </h6>
                                                                </td>
                                                            </tr>
                                                            <tr style="font-family: 'Roboto', sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                                                <td class="content-block"
                                                                    style="font-family: 'Roboto', sans-serif; color: #878a99; box-sizing: border-box; font-size: 15px; vertical-align: top; margin: 0; padding: 0 0 26px; text-align: center;"
                                                                    valign="top">
                                                                    {{$reason}}
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <div
                                            style="text-align: center; margin: 25px auto 0px auto;font-family: 'Roboto', sans-serif;">
                                            <h4 style="font-weight: 500; line-height: 1.5;font-family: 'Roboto', sans-serif;">
                                                {{__('emails.verifyEmail.needHelp', [], $locale)}} ?</h4>
                                            <p style="color: #878a99; line-height: 1.5;">{{__('emails.verifyEmail.contactInformation', [], $locale)}}
                                                <a href="mailto:{{config('mail.support_email')}}" style="font-weight: 500;">{{config('mail.support_email')}}</a></p>
                                            <p style="font-family: 'Roboto', sans-serif; font-size: 14px;color: #98a6ad; margin: 0px;">
                                                {{now()->year}} {{Str::title(config('client.company_name'))}}.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
</body>
</html>


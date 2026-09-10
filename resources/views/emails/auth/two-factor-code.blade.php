<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>Your {{ $appName }} verification code</title>
</head>
<body style="margin:0;padding:0;background:#e8eef5;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#0f172a;-webkit-text-size-adjust:100%;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#e8eef5;padding:36px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:560px;background:#ffffff;border-radius:20px;overflow:hidden;box-shadow:0 14px 40px rgba(15,23,42,0.08);">

                    <tr>
                        <td align="center" style="background:#ffffff;padding:28px 32px 20px;border-bottom:1px solid #eef2f7;">
                            @if (! empty($logoPath) && file_exists($logoPath) && isset($message))
                                <img
                                    src="{{ $message->embed($logoPath) }}"
                                    alt="{{ $appName }}"
                                    width="168"
                                    height="67"
                                    style="display:block;width:168px;max-width:70%;height:auto;border:0;margin:0 auto;"
                                >
                            @else
                                <p style="margin:0;font-size:28px;font-weight:800;color:#1e3a6d;letter-spacing:-0.03em;">
                                    {{ $appName }}
                                </p>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td style="height:4px;line-height:4px;font-size:0;background-color:#55b84d;">
                            &nbsp;
                        </td>
                    </tr>

                    <tr>
                        <td style="background:#1e3a6d;padding:28px 32px;">
                            <p style="margin:0 0 8px;font-size:11px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:#55b84d;">
                                Two-factor verification
                            </p>
                            <h1 style="margin:0;font-size:26px;line-height:1.25;font-weight:800;color:#ffffff;letter-spacing:-0.03em;">
                                Your verification code
                            </h1>
                            <p style="margin:12px 0 0;font-size:14px;line-height:1.55;color:#bfdbfe;">
                                Use this code to finish signing in to {{ $appName }}.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:32px;">
                            <p style="margin:0 0 16px;font-size:16px;line-height:1.6;color:#334155;">
                                Hi{{ filled($userName) ? ' '.$userName : '' }},
                            </p>
                            <p style="margin:0 0 24px;font-size:16px;line-height:1.6;color:#334155;">
                                Enter the code below to complete your sign-in. It expires in {{ $expireMinutes }} minutes.
                            </p>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 28px;">
                                <tr>
                                    <td align="center" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:14px;padding:22px 16px;">
                                        <p style="margin:0;font-size:36px;line-height:1;font-weight:800;letter-spacing:0.35em;color:#1e3a6d;font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,monospace;">
                                            {{ $code }}
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 16px;font-size:14px;line-height:1.6;color:#64748b;">
                                If you do not see this email in your inbox, check your spam or junk folder.
                            </p>

                            <p style="margin:0;font-size:14px;line-height:1.6;color:#64748b;">
                                If you did not try to sign in, you can ignore this message. Your account stays secure.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:0 32px 28px;">
                            <div style="border-top:1px solid #e2e8f0;padding-top:20px;text-align:center;">
                                <p style="margin:0 0 4px;font-size:13px;font-weight:700;color:#0b1220;">
                                    {{ $appName }}
                                </p>
                                <p style="margin:0;font-size:12px;line-height:1.5;color:#94a3b8;">
                                    Where opportunity meets talent ·
                                    <a href="{{ $appUrl }}" style="color:#1e3a6d;text-decoration:none;">Visit website</a>
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

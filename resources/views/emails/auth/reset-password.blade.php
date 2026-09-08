<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>Reset your {{ $appName }} password</title>
</head>
<body style="margin:0;padding:0;background:#e8eef5;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;color:#0f172a;-webkit-text-size-adjust:100%;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#e8eef5;padding:36px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:560px;background:#ffffff;border-radius:20px;overflow:hidden;box-shadow:0 14px 40px rgba(15,23,42,0.08);">

                    {{-- Brand header --}}
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

                    {{-- Accent bar --}}
                    <tr>
                        <td style="height:4px;line-height:4px;font-size:0;background:linear-gradient(90deg,#1e3a6d 0%,#55b84d 100%);background-color:#55b84d;">
                            &nbsp;
                        </td>
                    </tr>

                    {{-- Hero copy --}}
                    <tr>
                        <td style="background:#0b1220;padding:28px 32px;">
                            <p style="margin:0 0 8px;font-size:11px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:#55b84d;">
                                Password reset
                            </p>
                            <h1 style="margin:0;font-size:26px;line-height:1.25;font-weight:800;color:#ffffff;letter-spacing:-0.03em;">
                                Let’s get you back in.
                            </h1>
                            <p style="margin:12px 0 0;font-size:14px;line-height:1.55;color:#94a3b8;">
                                A secure link is ready for your {{ $appName }} account.
                            </p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:32px;">
                            <p style="margin:0 0 16px;font-size:16px;line-height:1.6;color:#334155;">
                                Hi{{ filled($userName) ? ' '.$userName : '' }},
                            </p>
                            <p style="margin:0 0 24px;font-size:16px;line-height:1.6;color:#334155;">
                                We received a request to reset the password for your account.
                                Click the button below to choose a new one.
                            </p>

                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 28px;">
                                <tr>
                                    <td align="center" bgcolor="#2f6b3a" style="border-radius:12px;">
                                        <a href="{{ $url }}"
                                           style="display:inline-block;padding:14px 28px;font-size:15px;font-weight:700;color:#ffffff;text-decoration:none;border-radius:12px;background:#2f6b3a;">
                                            Reset Password
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="margin:0 0 24px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;">
                                <tr>
                                    <td style="padding:16px 18px;">
                                        <p style="margin:0 0 6px;font-size:13px;font-weight:700;color:#0b1220;">
                                            This link expires in {{ $expireMinutes }} minutes
                                        </p>
                                        <p style="margin:0;font-size:13px;line-height:1.5;color:#64748b;">
                                            For your security, the reset link can only be used once.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 8px;font-size:13px;line-height:1.55;color:#64748b;">
                                If the button doesn’t work, copy and paste this link into your browser:
                            </p>
                            <p style="margin:0 0 24px;font-size:12px;line-height:1.5;word-break:break-all;">
                                <a href="{{ $url }}" style="color:#1e3a6d;text-decoration:underline;">{{ $url }}</a>
                            </p>

                            <p style="margin:0;font-size:14px;line-height:1.6;color:#64748b;">
                                If you didn’t request a password reset, you can safely ignore this email.
                                Your password will stay the same.
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
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

                <p style="margin:20px 0 0;font-size:11px;line-height:1.5;color:#94a3b8;max-width:560px;">
                    You’re receiving this email because a password reset was requested for an account
                    associated with this address.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>

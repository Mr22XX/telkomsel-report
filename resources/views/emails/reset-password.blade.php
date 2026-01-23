@component('mail::message')
<div style="text-align:center; margin-bottom:20px;">
    <img src="{{ $message->embed(public_path('icon.png')) }}"
         alt="Telkomsel Report"
         width="60">
</div>

# Halo 👋

Kami menerima permintaan untuk mereset password akun **Telkomsel Report** Anda.

Silakan klik tombol di bawah ini untuk mengatur ulang password Anda.

@component('mail::button', ['url' => $url, 'color' => 'red'])
Reset Password
@endcomponent

Link reset password ini hanya berlaku selama **60 menit**.

Jika Anda tidak merasa meminta reset password, silakan abaikan email ini.

<br>

Regards,  
**Mr22XX**
@endcomponent

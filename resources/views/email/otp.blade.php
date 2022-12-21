@component('mail::message')
# Olá {{$user->name}},
## Para confirmar sua conta acesse o link abaixo.

@component('mail::button', ['url' => route('account.confirm', [$user->email_check_token])])
    Clique aqui para confirmar!
@endcomponent
Obrigado,
{{ config('app.name') }}
@endcomponent

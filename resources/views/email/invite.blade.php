@component('mail::message')
# Olá {{$data->invitation_first_name}},
Você foi convidado para acessar os paginas da conta[XXXX].
<hr />
Para conferir acesse:
@component('mail::button', ['url' => ''])
    Verificar
@endcomponent
Obrigado,
{{ config('app.name') }}
@endcomponent

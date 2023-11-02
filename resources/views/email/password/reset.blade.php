@component('mail::message')
# Olá
<p>Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.</p>
@component('mail::button', ['url' => $url])
    Modificar Senha
@endcomponent
<p>Este link de redefinição de senha expirará em 60 minutos.</p>
<p>Se você não solicitou a redefinição de senha, nenhuma ação adicional será necessária.</p>
Saudações,<br/>
{{ config('app.name') }}
<hr/>
<p>Se você estiver com problemas para clicar no botão "Modificar Senha", copie e cole o URL abaixo em seu navegador da web:<a href="{{$url}}">{{$url}}</a></p>
@endcomponent



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bem-vindo à {{ $empresaNome }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4f46e5; color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; }
        .footer { background: #ddd; padding: 10px; text-align: center; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bem-vindo à {{ $empresaNome }}!</h1>
        </div>
        
        <div class="content">
            <p>Olá, <strong>{{ $nome }}</strong>!</p>
            
            <p>Seja muito bem-vindo à nossa equipe da <strong>{{ $empresaNome }}</strong>. Estamos muito felizes em tê-lo conosco.</p>
            
            <p>Seu cadastro foi realizado com sucesso em nosso sistema.</p>
            
            <p><strong>Seus dados:</strong></p>
            <ul>
                <li><strong>Nome:</strong> {{ $nome }}</li>
                <li><strong>Email:</strong> {{ $email }}</li>
            </ul>
            
            <p>Em breve entraremos em contato com mais informações.</p>
        </div>
        
        <div class="footer">
            <p>Atenciosamente,<br>Equipe {{ $empresaNome }}</p>
        </div>
    </div>
</body>
</html>
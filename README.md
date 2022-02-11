# razrv3telegram

## Descrição

Este programa é uma interface web em PHP do aplicativo telegram feito para uso em um Motorola Razr V3 (2004), capaz de enviar e receber mensagens.
Apesar ter sido feito tendo em mente o motorola v3, com conexão 2G, esta inteface web é capaz de ser usado em qualquer celular com conexão a internet.

## Vídeo

## Como funciona?

Esta interface faz uso de um bot do telegram que possue a função de ler todas as mensagens recebidas, sejam em grupos ou chats privados, e que por meio do API do telegram cria uma estrutura de dados JSON contendo os dados da mensagem recebida. 
Por meio do método ?getUpdates do API é possível executar pelo curl um requerimento GET e processar esses dados JSON em um servidor PHP.
Para maior comodidade esses dados são armazenados em um banco de dados mySQL e em seguida são processados conforme as demandas do usuário.
```
Mensagem recebida no telegram => Telegram Bot do usuário => API Telegram => JSON => método getUpdates no principal.php => mySQL => Mensagem é exibida no site
```
Para maior comodidade e evitar dar refresh em um celular com lenta conexão de internet, pode ser feito um "cron job" no servidor LAMP que executa a requerimento curl para ?getUpdates em um determinado período de tempo, assim, atualizando o banco de dados e o site automaticamente.

Para enviar mensagens, se faz uso do método da API do bot do telegram de nome ?sendMessage, no qual se pode enviar mensagens em grupos e chat privados.
Para maior comodidade em um celular com digitação limitada, foi criado um formulário html com método post no mesmo lugar onde são exibidas as mensagens recebidas, esse formulário envia o texto com método POST para uma página php na qual é tratado os dados e armazenados no banco de dados mySQL e finalmente enviado para o API do telegram.
```
Formulário html POST com texto enviado do V3 no site => enviar.php => sendMessage => Mensagem enviada para o telegram
                                                                   => mySQL => Mensagem armazenada => Mensagem exibida no site
```                                                                  
## A interface

Foi programado uma simples interface web PHP em um servidor LAMP hospedado em um antigo Raspberry Pi 2 com raspbian com a porta 80 aberta e ddns da no-ip para acesso em qualquer lugar. 
A página inicial home.php, possui os links para como se deseja fazer fetch no banco de dados mySQL, sendo subdividido em grupos, mensagens privadas e as últimas mensagens recebidas, sendo possível fácil customização com pouca edição de código. 
Já a página principal.php executa o método da API getUpdates e atualiza o banco de dados com os dados a serem exibidos e processados
A página enviar.php executa o método da API sendMessage no qual é responsável por enviar mensagens para telegram.
```
home.php => privadas.php => exibe mensagens privadas
         => ultimas.php => exibe todas as mensagens
         => grupo1.php => exibe mensagens do grupo1 => formulario para enviar texto => envio.php => grupo1.php com a mensagem enviada

principal.php => atualiza o banco de dados seja pelo cronjob ou pelo botão atualizar
enviar.php => envia mensagens do navegador para o telegram
```

## Limitações

- O bot do telegram não permite enviar mensagens privadas para contatos que nunca enviaram uma mensagem privada ao Bot, muitos bots se utilizam de /start para inicializar o bot, e assim descobrir o chat_ID necessário para envio, mas no caso de um bot que é usado para imitar um usuário, isso não funciona de maneira intuitiva, da mesma maneira que não é intuitivo o fato de uma pessoa estar tecnicamente conversando com um bot ao invés de um usuário. Uma das maneiras de se superar tal limitação talvez seja redirecionar as mensagens recebidas de um usuário para o Bot, mas para fazer isso talvez seja necessário um servidor dedicado pra esse propósito, pois o API do telegram não tem suporte para isso.
- O API do telegram permite envio de fotos, figurinhas e vídeos, mas levando em conta a lenta conexão 2G do RAZR V3, não faz sentido, usar desse mecanismo.
- O browser J2ME do Motorola V3 não tem suporte para AJAX, logo não é possível atualizar a página sem recarregar.

## Melhorias Futuras

- O presente código não tem suporte para enviar mensagens para contatos privados, mas isso é de fácil solução e logo será implementado.
- Também não há limite para o número de mensagens exibida no site, o que pode acarretar em uma demora no carregamento das páginas. Provavelmente o número de mensagens será limitado nas últimas 100-200 mensagens.
- Será implementado um modo de visualização rápida de mensagens inline, diferentemente de como é estruturado agora, para diminuir o scrolling no browser do RAZR V3.


                                                                   

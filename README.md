# FocusManager 🚀

**FocusManager** 
Meu projeto Focus Manager é uma aplicação cujo front-end é apenas uma interface gráfica projetada para demonstrar o funcionamento da API que desenvolvi. Utilizo Bootstrap 5 para criar um design responsivo, garantindo que a interface seja intuitiva e adaptável a diferentes dispositivos. A interação dinâmica entre o usuário e a aplicação é gerida com jQuery e AJAX, o que permite que os dados sejam atualizados sem a necessidade de recarregar a página. A organização do código JavaScript é feita com módulos ES6, facilitando a manutenção e escalabilidade do projeto.

A API foi desenvolvida em PHP, seguindo o padrão MVC (Model-View-Controller), garantindo uma arquitetura limpa e modular. Para o acesso seguro ao banco de dados, utilizo PDO, prevenindo ataques de SQL injection e promovendo segurança nas transações com o MySQL, que é o banco de dados utilizado. A implementação é toda orientada a objetos (POO), seguindo boas práticas de design e desenvolvimento.

O projeto também está containerizado usando Docker, o que facilita o desenvolvimento e o deployment em diferentes ambientes de forma consistente e segura.

A segurança é um ponto fundamental no Focus Manager. O sistema é protegido contra uma série de ameaças, como ataques XSS (Cross-site Scripting), SQL injection, DDoS, bots maliciosos e requisições excessivas. Além disso, todos os IDs dentro da aplicação são criptografados, adicionando uma camada extra de proteção para dados sensíveis.

Além disso, a aplicação gera logs diários, o que permite monitorar as atividades e garantir a rastreabilidade dos eventos, facilitando a identificação de possíveis problemas ou anomalias no sistema.

# Videos do Projeto 

Neste dois videos, eu demonstro o funcionamento tanto na parte de fontes como na parte do frontend ao qual foi desenvolvido apenas para demonstra o uso e consumo da API.

<h3>Explicando o projeto a parte Backend (API) e como baixar o mesmo:</h3>
<blockquote>
Para aprender como baixar o projeto, rodá-lo em sua máquina local e entender o desenvolvimento tanto no backend (Docker, MySQL, logs, criptografia, entre outros) quanto nas medidas de segurança implementadas para evitar ataques como XSS, DDoS, bots maliciosos, excesso de requisições por IP e SQL injection, basta <a href="https://drive.google.com/file/d/1FJzAn1_ke-KXtk2DoF2ZjhWM53hLPvt5/view?usp=sharing">clicar aqui</a>.
</blockquote>

<h3>Explicando o projeto na parte de FronEnd e seu funcionamento:</h3>
<blockquote>
Para entender como o projeto funciona no FrontEnd, que desenvolvi apenas para demonstrar a utilização da API, além de obter mais detalhes sobre os aspectos de segurança, como protocolos HTTP, requisições e consumo de dados, basta <a href="https://drive.google.com/file/d/19L9K8HdxXS6qP6NeSRiK_yul8lngTnHn/view?usp=sharing">clicar aqui</a>.
</blockquote>


## Requisitos 📋

Antes de começar, certifique-se de que você tem o PHP instalado e configurado na variável de ambiente da sua máquina.

### Verificar a Instalação do PHP

1. **Verifique se o PHP está instalado:**

   Abra um terminal (ou prompt de comando no Windows) e execute o seguinte comando:

   ```bash
   php -v


Você deve ver a versão do PHP instalada. Se o comando não for reconhecido, você precisará instalar o PHP e configurar a variável de ambiente.

Instalar o PHP (caso não esteja instalado):

No Windows:

Baixe o PHP <a href="https://www.php.net/downloads.php">Aqui</a> 💾.
Extraia o conteúdo em um diretório de sua escolha.
Adicione o caminho do diretório ao PATH das variáveis de ambiente.

No macOS (usando Homebrew):
<blockquote>
    1 - brew install php
</blockquote>

No Linux (Debian/Ubuntu):
<blockquote>
    1 - sudo apt update <br>
    2 - sudo apt install php
</blockquote>

<h1>Iniciando o Servidor Embutido do PHP 🚀</h1>
Para iniciar o servidor embutido do PHP e acessar o FocusManager, siga os passos abaixo:

Abra um terminal (ou prompt de comando) e navegue até o diretório public localizado na raiz do seu projeto:
<blockquote>
    cd /caminho/para/seu/projeto/FocusManager/public
</blockquote>

Inicie o servidor embutido do PHP na porta desejada:
<blockquote>
    php -S localhost:8888
</blockquote>
Substitua 8888 por qualquer número de porta disponível que você preferir, caso a porta 8888 já esteja em uso.

Acesse o projeto no navegador:

Abra o seu navegador e vá para http://localhost:8888. Se você escolheu uma porta diferente, ajuste a URL conforme a porta que você especificou.****

<h1>Estrutura do Projeto 🗂️</h1>
<ul>
    <li>/public: Contém arquivos acessíveis publicamente, como index.php, HTML, CSS e JavaScript.</li>
    <li>/app: Contém a lógica do MVC, incluindo Models, Views e Controllers.</li>
    <li>/vendor: Dependências do Composer (se estiver usando Composer).</li>
</ul>

<h1>Tecnologias Utilizadas ⚙️</h1>
<ul>
    <li>PHP: Lógica de servidor e implementação do padrão MVC.</li>
    <li>HTML: Estruturação do conteúdo da página.</li>
    <li>CSS: Estilização do conteúdo.</li>
    <li>JavaScript: Funcionalidade dinâmica e interatividade.</li>
    <li>Docker: Utilzado para criar contâneirs com imagem MySQl.</li>
    <li>Criptografia: Criptografia para proteger dados sigilosos.</li>
    <li>Segurança: Evita ataques XSS, SQL INJECTION, BOT MALICIOSOS, DDOS e altas requisições.</li>
</ul>

<h1>Resolução de Problemas 🛠️</h1>
<ul>
    <li>Porta em uso: Se a porta escolhida já estiver em uso, você verá uma mensagem de erro. Tente usar outra porta, substituindo o número da porta no comando php -S             localhost:8888.
    /li>
    <li>Erro "php não encontrado": Se o comando php -v não funcionar, isso pode indicar que o PHP não está instalado corretamente ou que a variável de ambiente não está configurada corretamente. Verifique a instalação e as variáveis de ambiente conforme as instruções acima.</li>
</ul>
